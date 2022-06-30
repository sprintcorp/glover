<?php


namespace App\Http\Traits;


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

trait ApiResponse
{
    private function successResponse($data,$code)
    {
        return response()->json(['message' =>$data],$code);
    }

    private function allResponse($data,$code=200)
    {
        return response()->json($data,$code);
    }

    protected function showModelWithMessage($model,$message,$code=200)
    {
        return response()->json(['message' => $message,'data'=>$model],$code);
    }

    protected function errorResponse($message,$code)
    {
        return response()->json(['error' => $message,'code'=>$code],$code);
    }

    protected function showAll($collection,$code = 200,$no = 10)
    {
        if($no < 1){
            $no = 10;
        }
        if($collection->isEmpty()){
            return $this->successResponse(['data' => $collection],$code);
        }
        $collection = $this->paginate($collection,$no);
        return $this->successResponse($collection,$code);
    }

    public function noPaginate($model,$code = 200){
        return $this->successResponse(['data' => $model],$code);
    }

    protected function showModel($model,$code = 200)
    {
        return response()->json(['data' =>$model],$code);
    }

    protected function showMessage($message,$code = 200)
    {
        return $this->successResponse($message,$code);
    }

    /**
     * @param Collection $collection
     * @param $transformer
     * @return Collection|mixed
     */
    protected function sortData($collection,$transformer)
    {
        if(request()->has('sort_by')){
            $attribute = $transformer::originalAttributes(request()->sort_by);
            $collection = $collection->sortBy->{$attribute};
        }
        return $collection;
    }

    /**
     * @param Collection $collection
     * @param $transformer
     * @return Collection|mixed
     */
    protected function filterData($collection, $transformer)
    {
        foreach (request()->query() as $query => $value){
            $attribute = $transformer::originalAttributes($query);
            if(isset($attribute,$value)){
                $collection = $collection->where($attribute,$value);
            }
        }
        return $collection;
    }

    /**
     * @param Collection $collection
     */
    protected function paginate($collection,$no)
    {
        $rules = [
            'per_page' => 'integer|min:2|max:50'
        ];
        Validator::validate(request()->all(),$rules);
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = $no;
        if(request()->has('per_page')){
            $perPage = (int) request()->per_page;
        }
        $result = $collection->slice(($page - 1) * $perPage,$perPage)->values();

        $paginated = new LengthAwarePaginator($result,$collection->count(),$perPage,$page,[
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);
        return $paginated;
    }
}
