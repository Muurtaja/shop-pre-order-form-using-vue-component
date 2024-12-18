<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Preorder;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function preorders(Request $request)
    {
        return $this->getPreorder($request);
    }
    public function trash(Request $request)
    {
        return $this->getPreorder($request, "onlyTrashed");
    }
    public function getPreorder(Request $request, $scope = null)
    {
        $perPage    = $request->input('per_page', 10);
        $searchTerm = $request->input('search', null);
        $orderBy = $request->input('orderBy', null);

        $query = Preorder::query();

        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('email', 'like', '%' . $searchTerm . '%')
                    ->orWhere('name', 'like', '%' . $searchTerm . '%');
            });
        }

        switch ($orderBy) {
            case 2:
                $query->oldest();
            case 3:
                $query->oldest("name");
                break;
            case 4:
                $query->latest("name");
                break;
            default:
                $query->latest();
                break;
        }

        if ($scope) {
            $query->$scope();
        }

        return response()->json($query->with(["product:id,name", "deletedBy:id,name"])->paginate($perPage));
    }
    public function softDelete($id)
    {
        $preorder = Preorder::find($id);

        if ($preorder) {
            $preorder->delete();
            return response()->json(['message' => 'Preorder soft deleted successfully.']);
        }

        return response()->json(['message' => 'Preorder not found.'], 404);
    }
    public function restore($id)
    {
        $preorder = Preorder::withTrashed()->find($id);

        if ($preorder) {
            $preorder->restore();
            return response()->json(['message' => 'Preorder restored successfully.']);
        }

        return response()->json(['message' => 'Preorder not found.'], 404);
    }
}
