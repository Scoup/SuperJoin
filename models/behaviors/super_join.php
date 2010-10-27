<?php
/**
 * SuperJoin Behavior
 * 
 * Usage:
 * 		Active the var $actsAs in your model to use the SuperJoin
 * 			- var $actsAs = array('SuperJoin');
 * 
 * 		Before the find you have to active the behavior (one time for each find)
 * 			- in controller: $this->ModelName->superjoin('AssociationModelName') or $this->ModelName->superjoin(array('AssociationModelName1', 'AssociationModelName2'))
 * 			- in model: $this->superjoin('AssociationModelName') or $this->superjoin(array('AssociationModelName1', 'AssociationModelName2'))
 * 
 * 		Make your find with HABTM conditions and be happy =]
 * 
 * Obs:
 * 		Work with containable:
 * 			- If you active some habtm association Model: only the results of this association conditions will show up
 * 			- This active models still not work with containable =/
 * 			- The others associations still working default
 * 			- You can use this with conditions for hasMany, belongsTo and hasOne conditions (cake default) 
 * 
 * @version 1.0
 * @link http://github.com/Scoup/SuperJoin
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author Léo Haddad (scoup001@gmail.com)
 *
 */
class SuperJoinBehavior extends ModelBehavior{
	
	/**
	 * Private status of behavior
	 * @var unknown_type
	 */
	private $active = false;
	
	/**
	 * Models HABTM to join tables
	 * @var array
	 */
	private $targets = array();
	
	/**
	 * Default Options
	 * @var unknown_type
	 */
	private $_defaultOptions = array(
		"type" => "left"
	);
	
	public $options = array();
	
	
	/* 
	 * Configure the options
	 */
	public function setup(&$model, $settings = array()){
		$this->options = Set::merge($this->_defaultOptions, $settings);
	}
	
	/* 
	 * Called before find to change the joins
	 */
	public function beforeFind(&$model, $query){
		if($this->active){
			foreach($this->targets as $target){
				$habtm = $model->hasAndBelongsToMany[$target];
				App::import("Model", $target);
				$association = new $target;
				$query["joins"][] = array(
						"table" => $habtm["joinTable"],
						"alias" => $habtm["with"],
						"type" => $this->options["type"],
						"conditions" => array(
							"$model->name.$model->primaryKey = {$habtm["with"]}.{$habtm["foreignKey"]}"
						)
					);
				$query["joins"][] = array(
						"table" => $association->useTable,
						"alias" => $association->name,
						"type" => $this->options["type"],
						"conditions" => array(
							"$association->name.$association->primaryKey = {$habtm["with"]}.{$habtm["associationForeignKey"]}"
						)
				);
			}
			$this->active = false;
		}
		return $query;
	}
	
	/**
	 * Active the join tables to next find
	 * @param $model Object
	 * @param $targets String or Array of HABTM associations
	 */
	public function superjoin(&$model, $targets){
		$this->active = true;
		if(!is_array($targets)) $targets = array($targets);
		$this->targets = $targets;
	}
}

