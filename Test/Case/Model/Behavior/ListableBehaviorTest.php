<?php
/**
 * Description of ListableBehaviorTest
 *
 * @author David Yell <neon1024@gmail.com>
 */
class ListableBehaviorTest extends CakeTestCase {

    private $Model = null;
    private $Tag = null;

/**
 * Detail which fixtures we'd like to use
 *
 * @var array
 */
    public $fixtures = array(
        'plugin.listing.post',
        'plugin.listing.tag',
    );

/**
 * I don't want fixtures loaded for every test
 *
 * @var bool
 */
    public $autoFixtures = false;

/**
 * Make sure that the custom find method appends the conditions
 *
 * @return void
 */
    public function testCustomFind() {
        $this->Model = new Model();
        $this->Model->useTable = false;
        $this->Model->primaryKey = 'id';
        $this->Model->displayField = 'display';
        $this->Model->Behaviors->attach('Listing.Listable', array(
                'relatedModelName' => 'RelatedModel',
                'relatedModelPrimaryKey' => 'id',
                'relatedModelDisplayField' => 'name'
            )
        );

        $state = 'before';
        $query = array();

        $expected = array(
            'fields' => array('id', 'display'),
            'contain' => array(
                'RelatedModel' => array(
                    'fields' => array('id','name')
                )
            )
        );

        $result = $this->Model->_findListing($state, $query);

        $this->assertEqual($result, $expected);
    }

/**
 * Ensure that running a find with the behaviour attached, we do actually
 * get some optgroups in the array back
 *
 * @return void
 */
    public function testResultsArrayHasOptGroups() {
        $this->loadFixtures('Post', 'Tag');

        $this->Tag = ClassRegistry::init('Tag');

        $this->Tag->Behaviors->attach('Listing.Listable', array(
                'relatedModelName' => 'Post',
                'relatedModelDisplayField' => 'title',
            )
        );

        $this->Tag->bindModel(array(
            'belongsTo' => array(
                'Post' => array(
                    'className' => 'Post',
                    'foreignKey' => 'post_id',
                )
            ))
        );

        $expected = array(
            'First post' => array(
                1 => 'Cats',
                2 => 'Dogs',
            ),
            'Second post' => array(
                3 => 'Fish'
            )
        );
        $result = $this->Tag->find('listing');

        $this->assertEqual($result, $expected);
    }

}
