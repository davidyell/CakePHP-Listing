<?php
/**
 * Description of PostFixture
 *
 * @author David Yell <neon1024@gmail.com>
 */

class PostFixture extends CakeTestFixture {

    public $fields = array(
        'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
        'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
        'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
        ),
        'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
    );

    public $records = array(
        array(
            'id' => 1,
            'title' => 'First post',
        ),
        array(
            'id' => 2,
            'title' => 'Second post',
        ),
        array(
            'id' => 3,
            'title' => 'Third post',
        ),
    );

}
