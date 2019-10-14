<?php

namespace UserFiles\Connectors\ManualConnector;

use Kiamo\Admin\Utility\Connectors\Entities\EntityInstance;
use Kiamo\Admin\Utility\Connectors\Entities\EntityLayout;
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorCompanyInterface;
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorContactInterface;
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorFileInterface;
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorInterface;
use Kiamo\Admin\Utility\Connectors\Interfaces\KiamoConnectorTicketInterface;
use Kiamo\Admin\Utility\Connectors\ParameterBag;

class ManualConnector implements KiamoConnectorInterface, KiamoConnectorCompanyInterface, KiamoConnectorContactInterface, KiamoConnectorFileInterface, KiamoConnectorTicketInterface
{
    static public function setLang($lang) {

    }

    public function setCid($cid) {

    }

    static public function getType() {
        return 'Manual connector';
    }

    public function isActivatable() {
        return true;
    }

    public function setActivationInfos($infos) {

    }

    public function getActivationInfos() {
        return [];
    }

    public function companyIsActive() {
        return true;
    }

    public function getCompanyLabel() {
        return '';
    }

    public function getCompanyLayout() {
        return new EntityLayout();
    }

    public function findCompanyById($id) {
        return new EntityInstance($this->getCompanyLayout(), $id);
    }

    public function findOneCompany(ParameterBag $parameters) {
        return null;
    }

    public function contactIsActive() {
        return true;
    }

    public function getContactLabel() {
        return '';
    }

    public function getContactLayout() {
        return new EntityLayout();
    }

    public function findContactById($id) {
        return new EntityInstance($this->getContactLayout(), $id);
    }

    public function findOneContact(ParameterBag $parameters) {
        return null;
    }

    public function fileIsActive() {
        return true;
    }

    public function getFileLabel() {
        return '';
    }

    public function getFileLayout() {
        return new EntityLayout();
    }

    public function findFileById($id) {
        return new EntityInstance($this->getFileLayout(), $id);
    }

    public function findOneFile(ParameterBag $parameters) {
        return null;
    }

    public function ticketIsActive() {
        return true;
    }

    public function getTicketLabel() {
        return '';
    }

    public function getTicketLayout() {
        return new EntityLayout();
    }

    public function findTicketById($id) {
        return new EntityInstance($this->getTicketLayout(), $id);
    }

    public function findOneTicket(ParameterBag $parameters) {
        return null;
    }
}