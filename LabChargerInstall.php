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
    $chargerPage = $helper->getAdminPage('lab_charger', 'ProcessList', null, null);

    // create ProcessLabCharge page
    $labChargesPage = $helper->getAdminPage('lab_charges',
                                            'ProcessLabCharge',
                                            $chargerPage->id, null);

    // create LabChargerItems page and process
    $labChargeItemsPage = $helper->getAdminPage('lab_charge_items',
                                            'ProcessLabChargeItem',
                                            $chargerPage->id, null);

    // create charger role and permission
    $chargerPermission = $this->wire('permissions')->add('charger-edit');
    $chargerRole = $this->wire('roles')->add('charger-admin');
    $chargerRole->addPermission($chargerPermission);
    $chargerRole->save();

    // create lab_charge_item field
    $options = array(
      'derefAsPage' => 1,
      'parent_id' => $labChargeItemsPage->id,
      'labelFieldName' => 'title',
      'inputfield' => 'InputfieldRadios',
      'required' => 1,
      'tags' => 'Charger'
    );
    $sentOptions = array(
      'flags' => Field::flagAccessEditor,
      'useRoles' => true,
      'viewRoles' => array('superuser', 'admin', 'intern', 'assistant'),
      'editRoles' => array('superuser', 'admin'),
      'tags' => 'Charger'
    );
    $lcif = $helper->getField(LabCharger::LabChargeItemFieldName, "FieldtypePage", $options);
    // create LabCharge page template
    $opt = array('tags'=>'Charger', 'datetimeFormat' => 'm/d/Y H:i:s');
    $lcf = array(
      'title'=> array('type'=>'FieldtypeTitle', 'options'=>array()),
      'lab_charge_item' => array('type'=>'FieldtypePage', 'options'=>$options),
      'lab_charge_reference_number' => array('type'=>'FieldtypeInteger', 'options'=>$opt),
      'lab_charge_amount' => array('type'=>'FieldtypeText', 'options'=>$opt),
      'lab_charge_ufid' => array('type'=>'FieldtypeText', 'options'=>$opt),
      'lab_charge_term' => array('type'=>'FieldtypeText', 'options'=>$opt),
      'lab_charge_due_date' => array('type'=>'FieldtypeDatetime', 'options'=>$opt),
      'lab_charge_reversal' => array('type'=>'FieldtypeCheckbox', 'options'=>$opt),
      'lab_charge_sent' => array('type'=>'FieldtypeCheckbox', 'options'=>$sentOptions)//,
      //'lab_charge_processed' => array('type'=>'FieldtypeCheckbox', 'options'=>$sentOptions)
    );
    $templateOptions = array('noChildren' => 1, 'noSettings' => 1, 'noUnpublish' => 1);
    $labChargeTemplate = $helper->getTemplate(LabCharger::LabChargeTemplateName, $lcf, 'Charger', $templateOptions);



    // create LabChargeItem page template
    $opt = array('tags'=>'Charger', 'datetimeFormat' => 'm/d/Y H:i:s');
    $trigOpt = array(
      'tags' => 'Charger',
      'description' => 'Use this field to provide the name of a php file to execute when a charge of this type is sent.',
      'note' => 'Trigger files should be placed in site/modules/LabCharger/triggers/<filename>.php (Do not include .php, that will be appended automatically).'
    );
    $amtOpt = array(
      'tags' => 'Charger',
      'description' => 'Charges of this type will be autopopulated with this as their default amount.',
    );
    $dueOpt = array(
      'tags' => 'Charger',
      'description' => 'Charges of this type will be autopopulated with a due date this many days after the current day.'
    );
    $lcif = array(
      'title'=> array('type'=>'FieldtypeTitle', 'options'=>array()),
      'lab_charge_item_type' => array('type'=>'FieldtypeText', 'options'=>$opt),
      'lab_charge_item_trigger' => array('type'=>'FieldtypeText', 'options'=>$trigOpt),
      'lab_charge_item_default_amount' => array('type'=>'FieldtypeText', 'options'=>$amtOpt),
      'lab_charge_item_default_due_date_buffer' => array('type'=>'FieldtypeInteger', 'options'=>$dueOpt)
    );
    $labChargeItemTemplate = $helper->getTemplate(LabCharger::LabChargeItemTemplateName, $lcif, 'Charger', $templateOptions);

    // save config data
    $configData = array(
      'lab_charges_id'=>$labChargesPage->id,
      'lab_charge_items_id'=>$labChargeItemsPage->id,
      'lab_charger_root_id'=>$chargerPage->id
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
    $helper->deletePageByName('lab_charger');

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
