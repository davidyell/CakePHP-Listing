<?php
/**
 * Description of ListableBehaviorTest
 *
 * @author David Yell <neon1024@gmail.com>
 */
class ListableBehaviorTest extends CakeTestCase {

/**
 * Setup the test and instantiate any models and fixtures that we need
 */
    public function setUp(){
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
    }

/**
 * Make sure that the custom find method appends the conditions
 */
    public function testCustomFind() {
        $findMethod = 'listing';
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

    // Make sure the array has the optgroup
    public function testResultsArrayHasOptGroups() {
        
    }

    // Test to make sure that the array which comes back from a find() is correct

}
