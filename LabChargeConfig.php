<?php
class LabChargeConfig extends ModuleConfig {
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
      'lab_charger_account_type' => array(
        'type' => 'InputfieldText',
        'value' => 'OTH',
        'label' => 'Account type for generated lab charge records.'
      ),
      'lab_charger_group_type' => array(
        'type' => 'InputfieldText',
        'value' => 'C',
        'label' => 'Group type for generated lab charge trailer records.'
      ),
      'lab_charger_origin_id' => array(
        'type' => 'InputfieldText',
        'value' => '000240',
        'label' => 'Origin ID for generated lab charge trailer records.'
      )
    ));
  }
}
?>
