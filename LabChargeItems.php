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

class LabChargeItems extends PagesType {

	protected $labChargeItems = null;

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
		return 'LabChargeItem';
	}

  /**
	 * Hook called when a lab charge is deleted
	 *
	 * @param Page $language
	 *
	 */
	public function ___deleted(Page $labChargeItem) {
		$this->updated($labChargeItem, 'deleted');
	}

	/**
	 * Hook called when a lab charge is added
	 *
	 * @param Page $language
	 *
	 */
	public function ___added(Page $labChargeItem) {
		$this->updated($labChargeItem, 'added');
	}

	/**
	 * Hook called when a lab charge is added or deleted
	 *
	 * @param Page $language
	 * @param string $what What occurred? ('added' or 'deleted')
	 *
	 */
	public function ___updated(Page $labChargeItem, $what) {
		$this->reloadLabCharges();
		$this->message("Updated lab charge item $labChargeItem->name ($what)", Notice::debug);
	}

}
