<?php

function check_collection($user_guid, $collection_name) {
    $collections = get_user_access_collections($user_guid);
    if (is_array($collections) && sizeof($collections) > 0) {
        foreach ($collections as $collection) {
            if ($collection->name == $collection_name) {
                return $collection->id;
            }
        }
    } else {
        return false;
    }
}

?>
