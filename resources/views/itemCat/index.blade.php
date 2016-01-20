@extends('layouts.default')

@section('main')
 <div class="row">
     @if (count($itemCat) > 0)
    <table class="table table-striped">
        <thead>
            <tr>
			    <th>id</th>
                <th>分类</th>
				<th>排序</th>
                
                <th><i class="icon-cog"></i></th>
            </tr>
        </thead>
        <tbody>
        
             @foreach ($itemCat as $value)
              
              
              <tr>
			         <td>{{ $value->id }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->sort }}</td>

                </tr>
             @endforeach
       
            
        </tbody>
    </table>

    
   
      @else
                 没记录
        @endif
    

	
@endsection