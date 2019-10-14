<?php

namespace UserFiles\Connectors\KiamoConnectorMixedSample;

require_once __DIR__ . '/../../../Api/ContactManager/API_CM_Requirements.php';

use Kiamo\Admin\Utility\Connectors\Entities\EntityField;
use Kiamo\Admin\Utility\Connectors\Entities\EntityLayout;
use Kiamo\Admin\Utility\Connectors\Exceptions\ConnectorException;
use Kiamo\Admin\Utility\Connectors\Fields\FieldCollection;
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorContactInterface;
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorConfigurableInterface;
use Kiamo\Admin\Utility\Connectors\ParameterBag;
use libraries\FieldService;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Translator;
use Kiamo\Entity\Messaging\Connector;

class KiamoConnectorMixedSample implements KiamoConnectorConfigurableInterface, KiamoConnectorContactInterface
{
    const defaultLang = 'en_US';

    /** @var \Symfony\Component\Translation\Translator */
    static private $_translator;
    static private $_lang = 'en_US';
    static private $_configFile;
    static private $_configFileError;

    private $_cid;
    private $_config;
    private $_configFields;
    private $_contactFields;

    public function __construct() {
        if (self::$_configFile === null) {
            $configFile = __DIR__ . '/config.php';

            if (!file_exists($configFile)) {
                self::$_configFileError = self::$_translator->trans('fichier_de_configuration_absent');
            } else {
                self::$_configFile = require($configFile);

                if (!is_array(self::$_configFile)) {
                    self::$_configFileError = self::$_translator->trans('le_fichier_configuration_doit_retourner_un_tableau');
                }

                foreach (self::$_configFile as $name => $config) {
                    if (!is_string($name) || trim($name) === '') {
                        self::$_configFileError = self::$_translator->trans('le_fichier_configuration_doit_retourner_un_tableau_de_connecteurs_valides');
                        break;
                    }
                }
            }
        }
    }

    public function setCid($cid) {
        $this->_cid = $cid;
    }

    public function setConfig($config) {
        if (array_key_exists('connector', $config)) {
            if (array_key_exists($config['connector'], self::$_configFile)) {
                $this->_config = self::$_configFile[$config['connector']];
            }
        }

        $this->_configFields = null;
    }

    static public function setLang($lang) {
        if (self::$_translator === null || self::$_lang !== $lang) {
            self::$_lang = $lang;

            $langFile = __DIR__ . '/translations/messages.' . $lang . '.yml';
            if (!file_exists($langFile)) {
                $lang = self::defaultLang;
                $langFile = __DIR__ . '/translations/messages.' . $lang . '.yml';
            }

            self::$_translator = new Translator($lang, new MessageSelector());
            self::$_translator->addLoader('yaml', new YamlFileLoader());
            self::$_translator->addResource('yaml', $langFile, $lang);
        }
    }

    static public function getLang() {
        return self::$_lang;
    }

    static public function getType() {
        return self::$_translator->trans('kiamo_connector_mixed_sample');
    }

    public function isActivatable() {
        if (self::$_configFileError !== null) {
            return self::$_configFileError;
        }

        if (count($this->_config) === 0) {
            return self::$_translator->trans('connecteur_non_configure');
        }

        if (!array_key_exists('key', $this->_config)) {
            return self::$_translator->trans('cle_dapi_non_configure');
        }

        if (!array_key_exists('base', $this->_config)) {
            try {
                $baseCollectionResource = new \USER_CM_BaseCollectionResource(new \USER_HTTPClient());
                $baseCollectionResource->setToken($this->_config['key']);

                $baseCollectionResource->get();
            } catch (\Exception $exc) {
                return sprintf(self::$_translator->trans('cle_dapi_%s_invalide'), $this->_config['key']);
            }

            return self::$_translator->trans('id_de_base_non_configure');
        }

        try {
            $baseFields = $this->getBaseFields();

            if (!array_key_exists('fields', $this->_config)) {
                return self::$_translator->trans('aucun_champ_configure');
            }

            $noField = true;
            while ($baseFields->valid()) {
                /** @var \USER_CM_Field $field */
                $field = $baseFields->current();
                if (in_array($field->getName(), $this->_config['fields'])) {
                    $noField = false;
                    break;
                }
                $baseFields->next();
            }

            if ($noField) {
                return self::$_translator->trans('aucun_champ_configure');
            }
        } catch (\Exception $e) {
            return $this->_getCMErrorMessage($e);
        }

        return true;
    }

    /**
     * @param \Exception $e
     * @return string
     */
    private function _getCMErrorMessage($e) {
        switch ($e->getMessage()) {
            case 'Error 400 : Token is not valid':
            case 'Error 403 : Token is not valid':
                return sprintf(self::$_translator->trans('cle_dapi_%s_invalide'), $this->_config['key']);
                break;
            case 'Error 404 : The requested resource was not found':
                return sprintf(self::$_translator->trans('identifiant_de_base_%s_invalide'), $this->_config['base']);
                break;
            default:
                return sprintf(self::$_translator->trans('impossible_de_recuperer_les_informations_de_la_base_veuillez_verifier_votre_configuration_le_serveur_a_retourne_lerreur_suivante_%s'), $e->getMessage());
                break;
        }
    }

    public function getConfigurationFields() {
        if ($this->_configFields === null) {
            $this->_configFields = new FieldCollection();

            if (self::$_configFileError === null) {
                $options = [];
                foreach (self::$_configFile as $id => $config) {
                    $name = $id;
                    if (array_key_exists('name', $config)) {
                        if (is_array($config['name'])) {
                            if (array_key_exists(self::$_translator->getLocale(), $config['name'])) {
                                $name = $config['name'][self::$_translator->getLocale()];
                            } else {
                                $name = reset($config['name']);
                            }
                        }
                    }

                    $options[$id] = $name;
                }

                $this->_configFields->add('connector', FieldCollection::TYPE_CHOICE, [
                    'label' => self::$_translator->trans('connecteur'),
                    'empty_value' => gettext('Sélectionnez une entité'),
                    'choices' => $options
                ]);

                $this->_configFields->add('sampleSelectMultiple', FieldCollection::TYPE_CHOICE, [
                    'label' => 'Options select (sample)',
                    'choices' => ['option 1', 'option 2', 'option 3'],
                    'multiple' => true
                ]);

                $this->_configFields->add('sampleCheckboxMultiple', FieldCollection::TYPE_CHOICE, [
                    'label' => 'Options checkbox (sample)',
                    'choices' => ['option 1', 'option 2', 'option 3'],
                    'multiple' => true,
                    'expanded' => true
                ]);

                $this->_configFields->add('sampleRadio', FieldCollection::TYPE_CHOICE, [
                    'label' => 'Activer (sample)',
                    'choices' => [1 => 'Oui', 2 => 'Non'],
                    'expanded' => true
                ]);

                $this->_configFields->add('sampleCheckbox', FieldCollection::TYPE_CHECKBOX, [
                    'label' => 'Mode administrateur (sample)'
                ]);

                $this->_configFields->add('sampleText', FieldCollection::TYPE_TEXT, [
                    'label' => 'Text (sample)',
                    'defaultValue' => 'Texte par défaut'
                ]);

                $this->_configFields->add('sampleTextarea', FieldCollection::TYPE_TEXTAREA, [
                    'label' => 'Multi-line text (sample)'
                ]);

                $this->_configFields->add('samplePassword', FieldCollection::TYPE_PASSWORD, [
                    'label' => 'Password (sample)'
                ]);
            }
        }

        return $this->_configFields;
    }

    /**
     * @return \USER_CM_FieldCollection
     */
    private function getBaseFields() {
        $fieldCollectionResource = new \USER_CM_FieldCollectionByBaseResource(new \USER_HTTPClient());
        $fieldCollectionResource->setToken($this->_config['key']);

        return $fieldCollectionResource->get($this->_config['base']);
    }

    public function setActivationInfos($infos) {
        if (array_key_exists('fields', $infos)) {
            $this->_contactFields = $infos['fields'];
        }
    }

    public function getActivationInfos() {
        try {
            $fields = [];

            $baseFields = $this->getBaseFields();

            while ($baseFields->valid()) {
                $field = $baseFields->current();
                $fieldType = $field->getDataType();
                $default = $field->getType() === 'default';
                if (in_array($field->getName(), $this->_config['fields'])) {
                    $fields[$field->getName()] = [
                        'label' => $default ? null : $field->getLabel(),
                        'type' => $fieldType,
                        'default' => $default
                    ];
                }
                $baseFields->next();
            }
        } catch (\Exception $e) {
            throw new ConnectorException($this->_getCMErrorMessage($e));
        }

        return ['fields' => $fields];
    }

    public function contactIsActive() {
        return true;
    }

    public function getContactLabel() {
        return self::$_translator->trans('client');
    }

    public function getContactLayout() {
        $contactLayout = new EntityLayout(_('identifiant'));

        foreach ($this->_contactFields as $name => $infos) {
            if ($infos['visible']) {
                switch ($infos['type']) {
                    case 'phone':
                        $type = EntityField::TYPE_PHONE;
                        break;
                    case 'email':
                        $type = EntityField::TYPE_EMAIL;
                        break;
                    default:
                        $type = EntityField::TYPE_STRING;
                        break;
                }

                $label = $infos['label'];
                if ($infos['default']) {
                    $label = FieldService::getNameLabel($name);
                }

                $contactLayout->addField($name, $label, $type);
            }
        }

        return $contactLayout;
    }

    public function findContactById($id) {
        // TODO: Implement findContactById() method.
        return null;
    }

    public function findOneContact(ParameterBag $parameters) {
        $result = null;

        //If there is a KiamoConnectorFileSampleClientId variable defined in the local variables
        //and if it is completed,
        //we check if a client exists with this ID
        if ($parameters->KiamoConnectorFileSampleClientId !== '') {
            $result = $this->findContactById($parameters->KiamoConnectorFileSampleClientId);
            if ($result !== null) {
                return $result;
            }
        }

        //If there is a personalized parameter,
        //we search using this parameter
        if ($parameters->getParameter() !== '') {
            //TODO: search for a contact
        }

        //If no contact has been found and if there is a phone number,
        //we search data using the parameter
        if ($result === null && $parameters->CustNumber !== '') {
            //TODO: search for a contact
        }

        //If no contact has been found and if there is an email address,
        //we search data using the parameter
        if ($result === null && $parameters->EMailSender !== '') {
            //TODO: search for a contact
        }

        //If no contact has been found and if there are a stream type and a stream ID,
        //we search using these parameters
        if ($result === null && $parameters->StreamType !== '' && $parameters->StreamId !== '') {
            switch ($parameters->StreamType) {
                case Connector::STREAM_FACEBOOK:
                    //TODO: search for a contact using his Facebook ID
                case Connector::STREAM_TWITTER:
                    //TODO: search for a contact using his Twitter ID
                case Connector::STREAM_LINKEDIN:
                    //TODO: search for a contact using his Linkedin ID 
                default:
                    //TODO: search for a contact using his generic flow ID
            }
        }

        return $result;
    }
}