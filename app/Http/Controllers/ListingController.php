<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    //show all listings
    public function index(){
        
        return view('listings.index', [

        'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(4)
]);
    }

    //show single listings
    public function show(Listing $listing){

        return view('listings.show',[
        'listing' =>$listing
    ]);

    }

    //Show create form

    public function create(){
        return view('listings.create');
    }

    //Store Listing data

    public function store(Request $request)
{
    $formFields = $request->validate([
        'title' => 'required',
        'company' => ['required', Rule::unique('listings', 'company')],
        'location' => 'required',
        'website' => 'required',
        'email' => ['required', 'email'],
        'tags' => 'required',
        'description' => 'required',
    ]);

    if($request->hasFile('logo')){
        $formFields['logo'] = $request->file('logo')->store('logos','public');
    }
 
    $formFields['user_id'] = auth()->id();
    Listing::create($formFields);



    return redirect('/')->with('message','Listing Created Successfully!');
    }

    //Show edit form

    public function edit(Listing $listing){

        return view('listings.edit', ['listing' => $listing]);

    }


     //Update Listing data

    public function update(Request $request, Listing $listing)
{

    // make sure logged user is owner

    if($listing->user_id != auth()->id()){
        abort(403,'unauthorized Action');

    }
    $formFields = $request->validate([
        'title' => 'required',
        'company' => ['required'],
        'location' => 'required',
        'website' => 'required',
        'email' => ['required', 'email'],
        'tags' => 'required',
        'description' => 'required',
    ]);

    if($request->hasFile('logo')){
        $formFields['logo'] = $request->file('logo')->store('logos','public');
    }

    

    $listing->update($formFields);



    return back()->with('message','Listing updated Successfully!');
    }



    //Delete Listing

    public function destroy(Listing $listing){

        if($listing->user_id != auth()->id()){
        abort(403,'unauthorized Action');

    }

        $listing->delete(); 
        return redirect('/')->with('message','Listing deleted Successfully!');
    }

    //Manage Listing

    public function manage() {
    return view('listings.manage', [
        'listings' => auth()->user()->listings
    ]);
}


}
