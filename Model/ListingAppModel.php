<?php
/**
 * CakePHP ListingAppModel
 * @author David Yell <neon1024@gmail.com>
 */

App::uses('AppModel', 'Model');

class ListingAppModel extends AppModel {

/**
 * Add in custom find methods
 *
 * @var array
 */
    public $findMethods = array(
        'listing' => true
    );

/**
 * Setup custom find method which automatically attaches Provider
 *
 * @param string $state Either 'before' or 'after'
 * @param string $query The query to be executed
 * @param array $results Cake data array
 * @return array
 */
    public function _findListing($state, $query, $results = array()) {
        if($state == 'before'){
            $query['fields'] = array($this->primaryKey, $this->displayField);
            $query['contain'] = array(
                'Provider' => array(
                    'fields' => array('id','name')
                )
            );
            return $query;
        }
        return $results;
    }

}
