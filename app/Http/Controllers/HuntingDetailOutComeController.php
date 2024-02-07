<?php

namespace App\Http\Controllers;

use App\Models\HuntingDetail;
use App\Models\HuntingDetailOutCome;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HuntingDetailOutComeController extends Controller
{
    //index
    public function index(Organisation $organisation, HuntingDetail $huntingDetail)
    {
        $huntingActivity = $huntingDetail->huntingActivity;

        return view('organisation.hunting_activities.hunting_detail_out_comes',compact('organisation', 'huntingDetail', 'huntingActivity'));
    }

    public function store(Request $request, Organisation $organisation, HuntingDetail $huntingDetail)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'hunter_id' => 'required|exists:hunters,id',
            'professional_hunter' => 'nullable|string',
            'shot_id' => 'required|exists:shots,id',
            'location_of_shot' => 'nullable|string',
            'number_of_shots' => 'nullable|integer',
            'hunting_out_come_id' => 'required|exists:hunting_out_comes,id',
            'number_of_misses' => 'nullable|integer',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
            'pictures' => 'nullable|array',
            'pictures.*' => 'image', // Validates each file in the array is an image
        ]);

        // Handle file uploads if pictures are provided
        $pictures = [];
        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $picture) {
                // Define the destination path
                $destinationPath = 'organisation/hunting_details_pictures';

                // Use the original file name, or generate a unique one, for the file to be moved
                // It's important to ensure the filename is unique to avoid overwriting existing files
                $filename = time() . '_' . $picture->getClientOriginalName();

                // Move the file to the destination path with the specified filename
                $picture->move($destinationPath, $filename);

                // Add the path of the moved file to the pictures array
                // Note: Laravel's `public_path()` function gets the fully qualified path to the public directory
                // You might need to adjust the path depending on how you want to access these images later
                $pictures[] = $destinationPath . '/' . $filename;
            }
        }

        // Create a new HuntingDetailOutcome record
        $huntingDetail->huntingDetailOutComes()->create([
            'hunter_id' => $validatedData['hunter_id'],
            'professional_hunter' => $validatedData['professional_hunter'],
            'shot_id' => $validatedData['shot_id'],
            'location_of_shot' => $validatedData['location_of_shot'],
            'number_of_shots' => $validatedData['number_of_shots'],
            'hunting_out_come_id' => $validatedData['hunting_out_come_id'],
            'number_of_misses' => $validatedData['number_of_misses'],
            'longitude' => $validatedData['longitude'],
            'latitude' => $validatedData['latitude'],
            'pictures' => json_encode($pictures), // Store pictures as a JSON string
        ]);


        // Redirect or return response after saving
        return redirect()->route('organisation.hunting-detail-outcome.index',[$organisation->slug,$huntingDetail->slug])->with('success', 'Hunting detail outcome saved successfully.');
    }

    //destroy
    public function destroy(Organisation $organisation, HuntingDetailOutCome $huntingDetailOutCome)
    {

        $huntingDetail = $huntingDetailOutCome->huntingDetail;
        // Decode the JSON pictures field into an array
        $pictures = json_decode($huntingDetailOutCome->pictures, true);

        // Check if there are any pictures to delete
        if ($pictures) {
            foreach ($pictures as $picture) {
                // Construct the full path to the file
                $picturePath = public_path($picture); // `public_path` helper generates a full path to the file in the public directory

                // Check if the file exists before attempting to delete
                if (file_exists($picturePath)) {
                    // Use PHP's unlink function to delete the file
                    unlink($picturePath);
                }
            }
        }

        // Delete the hunting detail outcome
        $huntingDetailOutCome->delete();

        // Redirect with a success message
        return redirect()->route('organisation.hunting-detail-outcome.index', [$organisation->slug, $huntingDetail->slug])
            ->with('success', 'Hunting detail outcome deleted successfully.');
    }



}
