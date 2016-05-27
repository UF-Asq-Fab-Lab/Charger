<?php

/**
 * Installer and uninstaller for LabCharger module
 *
 * Thomas R Storey, 2015
 * Licensed under MIT License, see LICENSE.TXT
 *
 * http://fablab.arts.ufl.edu
 * https://github.com/UF-Asq-Fab-Lab
 */

class LabChargerInstall extends Wire {
  public function ___install() {

    $adminPage = $this->pages->get($this->config->adminRootPageID);
    $helper = $this->modules->get('FabLabModuleHelpers');

    // create ProcessList page
    $chargerPage = $helper->getAdminPage('charger', 'ProcessList');

    // create ProcessLabCharge page
    $labChargesPage = $helper->getAdminPage('lab_charges',
                                            'ProcessLabCharge',
                                            $chargerPage->id);
    // create LabCharge page template
    $opt = array('tags'=>'Charger', 'datetimeFormat' => 'm/d/Y H:i:s');
    $lcf = array(
      'title'=> array('type'=>'FieldtypeTitle', 'options'=>array()),
      'lab_charge_amount' => array('type'=>'FieldtypeText', 'options'=>$opt),
      'lab_charge_ufid' => array('type'=>'FieldtypeText', 'options'=>$opt),
      'lab_charge_term' => array('type'=>'FieldtypeText', 'options'=>$opt),
      'lab_charge_due_date' => array('type'=>'FieldtypeDatetime', 'options'=>$opt),
      'lab_charge_reversal' => array('type'=>'FieldtypeCheckbox', 'options'=>$opt)
    );
    $labChargeTemplate = $helper->getTemplate(LabCharger::LabChargeTemplateName, $lcf, 'Charger');

    // create LabChargerItems page and process
    $labChargeItemsPage = $helper->getAdminPage('lab_charge_items',
                                            'ProcessLabChargeItem',
                                            $chargerPage->id);

    // create LabChargeItem page template
    $opt = array('tags'=>'Charger', 'datetimeFormat' => 'm/d/Y H:i:s');
    $lcif = array(
      'title'=> array('type'=>'FieldtypeTitle', 'options'=>array()),
      'lab_charge_item_type' => array('type'=>'FieldtypeFloat', 'options'=>$opt)
    );
    $labChargeItemTempalte = $helper->getTemplate(LabCharger::LabChargeItemTemplateName, $lcif, 'Charger');

    // save config data
    $configData = array(
      'lab_charges_id'=>$labChargesPage->id,
      'lab_charge_items_id'=>$labChargeItemsPage->id,
      'charger_root_id'=>$chargerPage->id
    );
    $this->wire('modules')->saveModuleConfigData('LabCharger', $configData);

    $this->message("Lab Charger installed! Go to Charger > Lab Charges to add and edit Charges.");
  }

  public function ___uninstall() {
    $data = $this->wire('modules')->getModuleConfigData($this);
    $helper = $this->wire('modules')->get('FabLabModuleHelpers');

    $helper->deletePagesByTemplate('lab_charge');
    $helper->deletePagesByTemplate('lab_charge_item');
    $helper->deleteTemplateByName('lab_charge');
    $helper->deleteTemplateByName('lab_charge_item');
    $helper->deletePageByName('lab_charges');
    $helper->deletePageByName('lab_charge_items');
    $helper->deletePageByName('charger');
    
    $labChargerFields = $this->fields->find('name*=lab_charge');
    foreach ($labChargerFields as $lcf) {
      if(!$lcf->numFieldgroups()){
        $this->message("Removing field: {$lcf->name}");
  			$this->fields->delete($lcf);
      }
    }

    Wire::setFuel('lab_charges', null);
    Wire::setFuel('lab_charge_items', null);

    $uninstallModules = array('ProcessLabCharge', 'ProcessLabChargeItem');
		foreach($uninstallModules as $name) {
			$this->modules->uninstall($name);
			$this->message("Uninstalled Module: $name");
		}

  }
}

?>
