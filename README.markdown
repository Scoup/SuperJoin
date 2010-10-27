# Super Join Behavior

Super Join is a behavior to CakePHP based on [Super Find](http://github.com/jrbasso/super_find) plugin from jrBasso 
This behavior joins the habtm tables, so you can use conditions in both tables.

Tested with CakePHP 1.3.0.

## Requirements

- PHP 4.3.2 or higher
- CakePHP

## Usage

To use, add the content of this behavior in app/models/behaviors/super_join.php

Active the var $actsAs in your model to use the SuperJoin
	- var $actsAs = array('SuperJoin');
 
Before the find you have to active the behavior (one time for each find)
	- in controller: $this->ModelName->superjoin('AssociationModelName') or $this->ModelName->superjoin(array('AssociationModelName1', 'AssociationModelName2'))
	- in model: $this->superjoin('AssociationModelName') or $this->superjoin(array('AssociationModelName1', 'AssociationModelName2'))

Make your find with HABTM conditions and be happy =]

## Obs:
	Work with containable:
		- If you active some habtm association Model: only the results of this association conditions will show up
		- This active models still not work with containable =/
		- The others associations still working default
		- You can use this with conditions for hasMany, belongsTo and hasOne conditions (cake default) 

## Examples

$this->Post->superjoin("Tag");

$this->Post->find("all", array(
        "conditions" => array("Tag.name" => "mytag", "Post.status" => 1)
        "contain" => array("User", "Model1", "Model2")
));

	/* Output = 
		array(
			array(
				'Post' => array('id' => 1, 'title' => 'Post 1', 'status' => 1),
				'Tag' => array(
					array('id' => 1, 'name' => 'mytag')
				),
				'User' => array('id' => 1, 'name' => 'User 1'),
				'Model1' => array(),
				'Model2' => array(),
			)
		)*/

You also can create a array for a lot of HABTM associations
ex: 
$this->Post->superjoin(array("Tag", "Model1"));

## License

Licensed under The MIT License (http://www.opensource.org/licenses/mit-license.php).
