<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\SubCategory;
use App\Models\Category;
use Exception;

class CategoryController extends Controller
{


    public function store(Request $request)
    {



        try {
            $validated = $request->validate([
                'sub_title' => 'required|string|max:255',
                'sub_desc'  => 'nullable|string',
                'category_id' => 'required|integer|exists:categories,id',
            ]);

            $lastSubCategory = SubCategory::orderBy('id', 'desc')->first();

            if ($lastSubCategory) {
                $lastNumber = (int) substr($lastSubCategory->subCategoriesNumber, 3);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }



            $subCategoriesNumber = 'DSC' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            $subcategory = SubCategory::create([
                'sub_title' => $validated['sub_title'],
                'subCategoriesNumber' => $subCategoriesNumber,
                'desc'  => $validated['sub_desc'] ?? null,
                'categoires_id' => $validated['category_id'] ?? null,
            ]);



            return response()->json([
                'status'  => 'success',
                'message' => 'SubCategory created successfully!',
                'data'    => $subcategory,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function save(Request $request)
    {

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'decs'  => 'nullable|string',
            ]);


            $lastCategory = Category::orderBy('id', 'desc')->first();

            if ($lastCategory) {
                $lastNumber = (int) substr($lastCategory->categoriesNumber, 3);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }


            $categoriesNumber = 'DC' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            $subcategory = Category::create([
                'title' => $validated['title'],
                'categoriesNumber' => $categoriesNumber,
                'decs'  => $validated['decs'] ?? null,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'SubCategory created successfully!',
                'data'    => $subcategory,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong!',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    function  fetch()
    {
        try {
            $subCategories = SubCategory::all();
            return response()->json([
                'success' => true,
                'subCategories' => $subCategories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch sub categories'
            ], 500);
        }
    }

    function getAll()
    {
        try {
            $categories  =  Category::all();
            return response()->json([
                'success' => true,
                'categories' => $categories,

            ]);
        } catch (Exception $r) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch sub categories'
            ], 500);
        }
    }


    public function deleteCategory(Request $request)
    {
       
        $validated = $request->validate([
            'id' => 'required|integer|exists:categories,id',
        ]);

        try {
            // Find the category
            $category = Category::findOrFail($validated['id']);

            
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while deleting the category.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    function destroy(Request $request) {
         $validated = $request->validate([
            'id' => 'required|integer|exists:sub_categories,id',
        ]);

        try {
            // Find the category
            $category = SubCategory::findOrFail($validated['id']);

            
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while deleting the category.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    
    }
    function updateCategory(Request $request) {
        try {
             $validated = $request->validate([
                'title' => 'required|string|max:255',
                'decs'  => 'nullable|string',
                'id' => 'required|integer|exists:categories,id',
            ]);

           

            $id  = $validated['id'];
            $subCategory = SubCategory::find($id);
            $subCategory->sub_title = $validated['title'];
            $subCategory->desc = $validated['decs'] ?? null;   
            $subCategory->update();

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully!',
                'data'    => $subCategory,
            ], 200);

          
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while updating the category.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    function updatSsubcategories(Request $request) {
        try {
             $validated = $request->validate([
                'sub_title' => 'required|string|max:255',
                'sub_desc'  => 'nullable|string',
                'category_id' => 'required|integer|exists:categories,id',
                'id' => 'required|integer|exists:sub_categories,id',
            ]);

            $id  = $validated['id'];
            $subcategory = SubCategory::find($id);
            $subcategory->sub_title = $validated['sub_title'];
            $subcategory->desc = $validated['sub_desc'] ?? null;   
            $subcategory->categoires_id = $validated['category_id'];
            $subcategory->update();

            return response()->json([
                'success' => true,
                'message' => 'SubCategory updated successfully!',
                'data'    => $subcategory,
            ], 200);

          
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while updating the sub category.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
