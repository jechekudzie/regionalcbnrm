<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //

    private function formatOrganisationTreeData($entities, $parentOrganisationId = null, $parentOrganisationName = null)
    {
        $data = [];

        foreach ($entities as $entity) {
            // Generate a unique random number for each entity
            $rand = $this->generateUniqueNumber(1, 1000000);

            if ($entity instanceof Organisation) {
                // If the entity is an Organisation, process it and its children
                $data[] = [
                    'id' => $rand . '-o-' . $entity->id,
                    'text' => $entity->name,
                    'type' => 'organisation',
                    'slug' => $entity->slug,
                    'parentId' => $parentOrganisationId, // Inherit from the OrganisationType or top-level
                    'parentName' => $parentOrganisationName,
                    // Process children OrganisationTypes, passing current Organisation as parent
                    'children' => $this->formatOrganisationTreeData($entity->organisationType->children, $rand . '-o-' . $entity->id, $entity->name),
                ];
            } elseif ($entity instanceof OrganisationType) {
                // If the entity is an OrganisationType, process it
                $data[] = [
                    'id' => $rand . '-ot-' . $entity->id,
                    'text' => $entity->name,
                    'type' => 'organisationType',
                    'slug' => $entity->slug,
                    'parentId' => $parentOrganisationId, // Inherit parent ID from the Organisation above
                    'parentName' => $parentOrganisationName, // Inherit parent name from the Organisation above
                    // Process child Organisations, maintaining current OrganisationType as parent
                    'children' => $this->formatOrganisationTreeData($entity->organisations, $rand . '-ot-' . $entity->id, $entity->name),
                ];
            }
        }

        return $data;
    }
}
