<?php
/**
 * Description of TagFixture
 *
 * @author David Yell <neon1024@gmail.com>
 */

class TagFixture extends CakeTestFixture {

    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
        'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'post_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'key' => 'index'),
        'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $records = array(
        array(
            'id' => 1,
            'name' => 'Cats',
            'post_id' => 1
        ),
        array(
            'id' => 2,
            'name' => 'Dogs',
            'post_id' => 1
        ),
        array(
            'id' => 3,
            'name' => 'Fish',
            'post_id' => 2
        ),
    );

}
