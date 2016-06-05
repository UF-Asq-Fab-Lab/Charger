<?php
class LabChargerConfig extends ModuleConfig {
  public function __construct() {
    $this->add(
    array(
      'lab_charges_id' => array(
        'type' => 'InputfieldInteger',
        'value' => 0,
        'label' => 'ID of parent page for all Lab Charge pages.'
      ),
      'lab_charge_items_id' => array(
        'type' => 'InputfieldInteger',
        'value' => 0,
        'label' => 'ID of parent page for all Lab Charge Item pages.'
      ),
      'lab_charger_root_id' => array(
        'type' => 'InputfieldInteger',
        'value' => 0,
        'label' => 'ID of Charger page, the root for Charger-related pages.'
      ),
      'lab_charger_server_url' => array(
        'type' => 'InputfieldText',
        'value' => 'http://localhost/webdav1',
        'label' => 'The URL of the remote server with which the Lab Charger module will communicate.'
      ),
      'lab_charger_server_incoming_path' => array(
        'type' => 'InputfieldText',
        'value' => '/incoming/',
        'label' => 'The path on the remote server to which to upload records to process.'
      ),
      'lab_charger_server_outgoing_path' => array(
        'type' => 'InputfieldText',
        'value' => '/outgoing/',
        'label' => 'The path on the remote server from which to retrieve processed records.'
      ),
      'lab_charger_server_user' => array(
        'type' => 'InputfieldText',
        'value' => 'testuser',
        'label' => 'The username to use for authentication on the remote server.'
      ),
      'lab_charger_server_password' => array(
        'type' => 'InputfieldText',
        'value' => 'testpassword',
        'label' => 'The password to use for authentication on the remote server.'
      ),
      'lab_charger_account_type' => array(
        'type' => 'InputfieldText',
        'value' => 'OTH',
        'label' => 'Account type for generated lab charge records.'
      ),
      'lab_charger_reference_code' => array(
        'type' => 'InputfieldText',
        'value' => 'AAFABLAB',
        'label' => 'Reference code prepended to reference numbers for individual charge detail records.'
      ),
      'lab_charger_group_type' => array(
        'type' => 'InputfieldText',
        'value' => 'C',
        'label' => 'Group type for generated lab charge trailer records.'
      ),
      'lab_charger_origin_id' => array(
        'type' => 'InputfieldText',
        'value' => '00240',
        'label' => 'Origin ID for generated lab charge trailer records.'
      ),
      'lab_charger_spring_start' => array(
        'type' => 'InputfieldDatetime',
        'value' => '1/28/2016',
        'label' => 'Start date for the spring semester this year.',
        'dateInputFormat' => 'm/d/Y',
        'timeInputFormat' => '',
        'datepicker' => 1
      ),
      'lab_charger_summer_start' => array(
        'type' => 'InputfieldDatetime',
        'value' => '5/2/2016',
        'label' => 'Start date for the summer semester this year.',
        'dateInputFormat' => 'm/d/Y',
        'timeInputFormat' => '',
        'datepicker' => 1
      ),
      'lab_charger_fall_start' => array(
        'type' => 'InputfieldDatetime',
        'value' => '8/26/2016',
        'label' => 'Start date for the fall semester this year.',
        'dateInputFormat' => 'm/d/Y',
        'timeInputFormat' => '',
        'datepicker' => 1
      ),
      'lab_charger_grace_period' => array(
        'type' => 'InputfieldInteger',
        'value' => 30,
        'label' => 'Number of days between charge being posted and charge coming due.'
      )
    ));
  }
}
?>
