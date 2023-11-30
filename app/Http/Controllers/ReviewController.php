<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Book;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Book $book)
    {
        return view('books.reviews.create', ['book' => $book]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Book $book)
    {
        $validator = Validator::Make(
            [
                'review' => $request['review'],
                'rating' => $request['rating'],
            ],
            [
                'review' => 'required|min:15',
                'rating' => 'required|min:1|max:5|integer',
            ]
        );

        if ($validator->fails())
        {
            session()->flash('error', 'Review field requires more than 15 characters!');
        }

        $data = $validator->validate();

        $book->reviews()->create($data);

        return redirect()->route('books.show', $book)->with('success', 'Review added successfully. Thank you!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
