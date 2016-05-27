<?php

/**
 * Infinity Fab Lab Charge Module
 *
 * Developed for the Infinity Fab Lab at the University of Florida.
 * Defines a Lab Charge page type which holds data and behaviors relevant to an
 * individual charge.
 *
 * Thomas R Storey, 2015
 * Licensed under MIT License, see LICENSE.TXT
 *
 * http://fablab.arts.ufl.edu
 * https://github.com/UF-Asq-Fab-Lab
 */

class LabCharges extends PagesType {

  /**
	 * Cached all published lab charges (for getIterator)
	 *
	 * We cache them so that the individual lab charge pages persist through saves.
	 *
	 */
	protected $labCharges = null;

	/**
	 * Like find() but returns only the first match as a Page object (not PageArray)
	 *
	 * This is an alias of the findOne() method for syntactic convenience and
   * consistency.
	 *
	 * @param string $selectorString
	 * @return Page|null
	 */
	public function get($selectorString) {
		$lc = parent::get($selectorString);
		return $lc;
	}

  public function getPageClass() {
		return 'LabCharge';
	}

  /**
	 * Hook called when a lab charge is deleted
	 *
	 * @param Page $language
	 *
	 */
	public function ___deleted(Page $labCharge) {
		$this->updated($labCharge, 'deleted');
	}

	/**
	 * Hook called when a lab charge is added
	 *
	 * @param Page $language
	 *
	 */
	public function ___added(Page $labCharge) {
		$this->updated($labCharge, 'added');
	}

	/**
	 * Hook called when a lab charge is added or deleted
	 *
	 * @param Page $language
	 * @param string $what What occurred? ('added' or 'deleted')
	 *
	 */
	public function ___updated(Page $labCharge, $what) {
		$this->reloadLabCharges();
		$this->message("Updated lab charge $labCharge->name ($what)", Notice::debug);
	}
  //
  // /**
	//  * Returns ALL lab cahrges, including those in the trash or unpublished, etc.
	//  *
	//  */
	// public function getAll() {
	// 	if($this->labChargesAll) return $this->labChargesAll;
	// 	$template = $this->getTemplate();
	// 	$parent_id = $this->getParentID();
	// 	$selector = "parent_id=$parent_id, template=$template, include=all, sort=sort";
	// 	$labChargesAll = $this->wire('pages')->find($selector, array(
	// 			'loadOptions' => $this->getLoadOptions(),
	// 		)
	// 	);
	// 	if(count($labChargesAll)) $this->labChargesAll = $labChargesAll;
	// 	return $labChargesAll;
	// }
  //
  // /**
	//  * Enable iteration of this class
	//  *
	//  */
	// public function getIterator() {
	// 	if($this->labCharges && count($this->labCharges)) return $this->labCharges;
	// 	$labCharges = new PageArray();
	// 	foreach($this->getAll() as $labCharge) {
	// 		if($labCharge->hasStatus(Page::statusUnpublished)
  //     || $labCharge->hasStatus(Page::statusHidden)) continue;
	// 		$labCharges->add($labCharge);
	// 	}
	// 	if(count($labCharges)) $this->labCharges = $labCharges;
	// 	return $labCharges;
	// }
  //
  // /**
	//  * Reload all lab charges
	//  *
	//  */
	// public function reloadLabCharges() {
	// 	$this->labCharges = null;
	// }

}
