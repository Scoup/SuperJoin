# Super Join Behavior

Super Join is a behavior to CakePHP based on [Super Find](http://github.com/jrbasso/super_find) plugin from jrBasso
This behavior joins the habtm tables, so you can use conditions in both tables.

Tested with CakePHP 2.1.0.

## Requirements

Version: 2.X (master):
- PHP 5.0 or higher
- CakePHP 2.X

## Usage

To use, add the content of this behavior in app/models/behaviors/super_join.php

Active the var $actsAs in your model to use the SuperJoin
	- var $actsAs = array('SuperJoin');

In your find you have to declare the superjoin
	- in controller: $this->ModelName->find("all", array("superjoin" => array("AssociationModelName1", "AssociationModelName2"), "conditions" => array()));
	- in model: $this->find("all", array("superjoin" => array("AssociationModelName1", "AssociationModelName2"), "conditions" => array()));

Make your find with HABTM conditions and be happy =]

## Obs:
	Work with containable:
		- If you active some habtm association Model: only the results of this association conditions will show up
		- This active models still not work with containable =/
		- The others associations still working default
		- You can use this with conditions for hasMany, belongsTo and hasOne conditions (cake default)

## Examples

$this->Post->find("all", array(
        "conditions" => array("Tag.name" => "mytag", "Post.status" => 1)
        "contain" => array("User", "Model1", "Model2"),
	"superjoin" => array("Tag")
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
$this->Post->find("all", array(
        "conditions" => array("Tag.name" => "mytag", "Post.status" => 1)
        "contain" => array("User", "Model1", "Model2"),
	"superjoin" => array("Tag", "Model1")
));

##News version 2.x (master)
	- Work with Cakephp 2.X

##News version 1.1
	- Dont need to active anymore
	- Works like containble
	- Works with paginate

## License

Licensed under The MIT License (http://www.opensource.org/licenses/mit-license.php).
