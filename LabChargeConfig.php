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
      'charger_root_id' => array(
        'type' => 'InputfieldInteger',
        'value' => 0,
        'label' => 'ID of Charger page, the root for Charger-related pages.'
      )
    ));
  }
}
?>
