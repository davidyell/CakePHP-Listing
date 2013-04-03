<?php
/**
 * Listable behaviour for appending a model to a list of items for a select
 *
 * @author David Yell <neon1024@gmail.com>
 */

class ListableBehavior extends ModelBehavior {

/**
 * Allows the mapping of preg-compatible regular expressions to public or
 * private methods in this class, where the array key is a /-delimited regular
 * expression, and the value is a class method. Similar to the functionality of
 * the findBy* / findAllBy* magic methods.
 *
 * @var array
 */
    public $mapMethods = array(
        '/listing/' => '_findListing'
    );

/**
 * The settings for this behaviour
 *
 * @var array
 *
 * @item mode 'array' or 'string' Control whether you want a string returned
 *  or an optgroup style array
 */
    public $settings = array(
        'relatedModel' => array(
                'name' => '',
                'primaryKey' => 'id',
                'displayField' => 'name'
            ),
        'mode' => 'array'
    );

/**
 * Add in the listing find method
 *
 * @var array
 */
    public $findMethods = array(
        'listing' => true
    );

/**
 * Setup this behavior with the specified configuration settings.
 *
 * @param Model $model Model using this behavior
 * @param array $config Configuration settings for $model
 * @return void
 */
    public function setup(\Model $model, $config = array()) {
        // Add our custom find method to this model
        $model->findMethods = Hash::merge($model->findMethods, $this->findMethods);

        // If the behaviour has been configured, merge in the settings
        if (!empty($config)) {
            $this->settings = Hash::merge($this->settings, $config);
        }
    }

/**
 *
 *
 * @param Model $model
 * @param type $findMethod
 * @param type $state
 * @param type $query
 * @param type $results
 * @return array
 */
    public function _findListing(Model $model, $findMethod, $state, $query, $results = array()) {
        if($state == 'before'){
            $query['fields'] = array($model->primaryKey, $model->displayField);
            $query['contain'] = array(
                $this->settings['relatedModel']['name'] => array(
                    'fields' => array($this->settings['relatedModel']['primaryKey'], $this->settings['relatedModel']['displayField'])
                )
            );
            return $query;
        }
        return $results;
    }

/**
 * Changes a list of data into a list with extra information
 *
 * @param \Model $model The calling model
 * @param array $results Cake data array
 * @param boolean $primary
 * @return array Cake data array
 */
    public function afterFind(Model $model, $results, $primary) {
        foreach($results as $row){
            if (isset($row[$model->name])) {
                if ($this->settings['mode'] == 'string') {
                    $list[$row[$model->name]['id']] = "(".$row['Provider']['name'].") ".$row[$model->name]['name'];
                } else if ($this->settings['mode'] == 'array') {
                    $list[$row['Provider']['name']][$row[$model->name]['id']] = $row[$model->name]['name'];
                } else {
                    throw new BadMethodCallException($this->settings['mode'].' is not a valid mode.');
                }
            }
        }

        if (isset($list) && is_array($list)) {
            return $list;
        } else {
            return $results;
        }
    }



}