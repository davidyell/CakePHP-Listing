<?php
/**
 * Listable behaviour for appending a model to a list of items for a select
 *
 * @author David Yell <neon1024@gmail.com>
 */

class ListableBehavior extends ModelBehavior {

/**
 * Changes a list of data into a list of (Provider name) Item
 *
 * @param \Model $model The calling model
 * @param array $results Cake data array
 * @param boolean $primary
 * @return array Cake data array
 */
    public function afterFind(Model $model, $results, $primary) {
        foreach($results as $row){
            if (isset($row[$model->name])) {
                $list[$row[$model->name]['id']] = "(".$row['Provider']['name'].") ".$row[$model->name]['name'];
            }
        }

        if (isset($list)) {
            return $list;
        } else {
            return $results;
        }
    }

}