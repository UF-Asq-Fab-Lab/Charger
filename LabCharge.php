<?php
/**
 * Infinity Fab Lab Charge Class
 *
 * Developed for the Infinity Fab Lab at the University of Florida.
 * Defines a Lab Charge page type which holds data and behaviors relevant to an
 * individual charge.
 *
 * Thomas R Storey, 2016
 * Licensed under MIT License, see LICENSE.TXT
 *
 * http://fablab.arts.ufl.edu
 * https://github.com/UF-Asq-Fab-Lab
 */

class LabCharge extends Page {

  /**
	 * Create a new Lab Charge page in memory.
	 *
	 * @param Template $tpl Template object this page should use.
	 *
	 */
	public function __construct(Template $tpl = null) {
		if(is_null($tpl)) $tpl = $this->wire('templates')->get('lab_charge');
		parent::__construct($tpl);
	}

  /**
	 * Returns the URL where this page can be edited
	 *
	 * In this case we adjust the default page editor URL to ensure lab charges
   * are edited only from the Charger section.
	 *
	 * @return string
	 *
	 */
	public function editUrl() {
		return str_replace('/page/edit/', '/charger/lab_charges/edit/', parent::editUrl());
	}

	/**
	 * Set the Process module (WirePageEditor) that is editing this User
	 *
	 * We use this to detect when the Lab Charge is being edited somewhere outside
   * of /charger/lab_charges/
	 *
	 * @param WirePageEditor $editor
	 *
	 */
	public function ___setEditor(WirePageEditor $editor) {
		parent::___setEditor($editor);
		if(!$editor instanceof ProcessLabCharge) $this->wire('session')->redirect($this->editUrl());
	}

  /**
	 * Render charge detail string for this charge.
	 *
	 * @return string $detail
	 *
	 */

  public function renderDetail() {
    $detail = "";
    // TODO:
    return $detail;
  }

  /**
	 * Return the API variable used for managing pages of this type
	 *
	 * @return Pages|PagesType
	 *
	 */
	public function getPagesManager() {
		return $this->wire('lab_charges');
	}

}
?>
