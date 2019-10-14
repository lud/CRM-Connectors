<?php

namespace UserFiles\Connectors\KiamoConnectorFileSample;

require_once __DIR__ . '/../../Api/ContactManager/API_CM_Requirements.php';

use Kiamo\Bundle\AdminBundle\Utility\Connectors\Entities\EntityField;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Entities\EntityLayout;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Exceptions\ConnectorException;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorContactInterface;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\Interfaces\KiamoConnectorInterface;
use Kiamo\Bundle\AdminBundle\Utility\Connectors\ParameterBag;
use libraries\FieldService;
use Kiamo\Entity\Messaging\Connector;

class KiamoConnectorFileSample implements KiamoConnectorInterface, KiamoConnectorContactInterface
{
    const txtDomain = 'kiamoconnectorfilesample';

    static private $_config;
    static private $_configError;
    static private $_domInit = false;

    private $_cid;
    private $_contactFields;

    public function __construct() {
        if (self::$_config === null) {
            $configFile = __DIR__ . '/config.php';

            if (!file_exists($configFile)) {
                self::$_configError = dgettext(self::txtDomain, 'fichier_de_configuration_absent');
            } else {
                self::$_config = require($configFile);

                if (!is_array(self::$_config)) {
                    self::$_configError = dgettext(self::txtDomain, 'le_fichier_configuration_doit_retourner_un_tableau');
                }
            }
        }
    }

    static public function setLang($lang) {
        if (!self::$_domInit) {
            self::$_domInit = true;
            bindtextdomain(self::txtDomain, __DIR__ . '/locale');
        }
    }

    public function setCid($cid) {
        $this->_cid = $cid;
    }

    static public function getType() {
        return dgettext(self::txtDomain, 'kiamo_connector_file_sample');
    }

    public function isActivatable() {
        if (self::$_configError !== null) {
            return self::$_configError;
        }

        if (count(self::$_config) === 0) {
            return dgettext(self::txtDomain, 'connecteur_non_configure');
        }

        if (!array_key_exists('key', self::$_config)) {
            return dgettext(self::txtDomain, 'cle_dapi_non_configure');
        }

        if (!array_key_exists('base', self::$_config)) {
            try {
                $baseCollectionResource = new \USER_CM_BaseCollectionResource(new \USER_HTTPClient());
                $baseCollectionResource->setToken(self::$_config['key']);

                $baseCollectionResource->get();
            } catch (\Exception $exc) {
                return sprintf(dgettext(self::txtDomain, 'cle_dapi_%s_invalide'), self::$_config['key']);
            }

            return dgettext(self::txtDomain, 'id_de_base_non_configure');
        }

        try {
            $baseFields = $this->getBaseFields();

            if (!array_key_exists('fields', self::$_config)) {
                return dgettext(self::txtDomain, 'aucun_champ_configure');
            }

            $noField = true;
            while ($baseFields->valid()) {
                $field = $baseFields->current();
                if (in_array($field->getName(), self::$_config['fields'])) {
                    $noField = false;
                    break;
                }
                $baseFields->next();
            }

            if ($noField) {
                return dgettext(self::txtDomain, 'aucun_champ_configure');
            }
        } catch (\Exception $e) {
            return $this->_getCMErrorMessage($e);
        }

        return true;
    }

    private function _getCMErrorMessage($e) {
        switch ($e->getMessage()) {
            case 'Error 400 : Token is not valid':
            case 'Error 403 : Token is not valid':
                return sprintf(dgettext(self::txtDomain, 'cle_dapi_%s_invalide'), self::$_config['key']);
                break;
            case 'Error 404 : The requested resource was not found':
                return sprintf(dgettext(self::txtDomain, 'identifiant_de_base_%s_invalide'), self::$_config['base']);
                break;
            default:
                return sprintf(dgettext(self::txtDomain, 'impossible_de_recuperer_les_informations_de_la_base_veuillez_verifier_votre_configuration_le_serveur_a_retourne_lerreur_suivante_%s'), $e->getMessage());
                break;
        }
    }

    private function getBaseFields() {
        $fieldCollectionResource = new \USER_CM_FieldCollectionByBaseResource(new \USER_HTTPClient());
        $fieldCollectionResource->setToken(self::$_config['key']);

        return $fieldCollectionResource->get(self::$_config['base']);
    }

    public function setActivationInfos($infos) {
        if (array_key_exists('fields', $infos)) {
            $this->_contactFields = $infos['fields'];
        }
    }

    public function getActivationInfos() {
        try {
            $baseFields = $this->getBaseFields();

            while ($baseFields->valid()) {
                $field = $baseFields->current();
                $fieldType = $field->getDataType();
                $default = $field->getType() === 'default';
                if (in_array($field->getName(), self::$_config['fields'])) {
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
        return dgettext(self::txtDomain, 'client');
    }

    public function getContactLayout() {
        $contactLayout = new EntityLayout(_('identifiant'));

        foreach ($this->_contactFields as $name => $infos) {
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
        //we search using this parameter
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