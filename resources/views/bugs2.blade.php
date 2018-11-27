@extends('layouts.app')
@section('content')
<link href="{{ asset('css/app0.css') }}" rel="stylesheet">
  <div class="container">
    <div class="col-sm-offset-1 col-sm-10">
	<div class="panel panel-default">
	    <div class="panel-heading">
		New Bug
	    </div>

	    <div class="panel-body">

<!--  -->
    <!--成功時のメッセージ-->
    <!-- @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif -->
<!--  -->

		<!-- Display Validation Errors -->
		@include('common.errors')

		<!-- New Bug Form -->
		<form action="{{ url('bug')  }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
		    {{ csrf_field() }}

		    <!-- Bug Name  -->
		    <div class="form-group">
			<label for="bug-name" class="col-sm-3 control-label">Name</label>
			<div class="col-sm-6">
			    <input type="text" name="name" id="bug-name" class="form-control">
			</div>
		    </div>

        <div class="form-group">
			<label for="bug-address" class="col-sm-3 control-label">Mail Address</label>
			<div class="col-sm-6">
			    <input type="text" name="address" id="bug-address" class="form-control">
			</div>
		    </div>

        <div class="form-group">
			<label for="bug-title" class="col-sm-3 control-label">Title</label>
			<div class="col-sm-6">
			    <input type="text" name="title" id="bug-title" class="form-control">
			</div>
		    </div>

        <div class="form-group">
			<label for="bug-body" class="col-sm-3 control-label">Body</label>
			<div class="col-sm-6">
          <textarea name="body" id="bug-body" class="form-control"></textarea>
			    <!-- <input type="text" name="body" id="bug-body" class="form-control"> -->
			</div>
		    </div>

<!--  -->
        <div class="form-group">
          <label for="image" class="col-sm-3 control-label">Image</label>
          <div class="col-sm-6">
            <input type="file" name="file">
          </div>
        </div>
<!--  -->

		    <!-- Add Bug Button -->
		    <div class="form-group">
			<div class="col-sm-offset-3 col-sm-6">
			    <button type="submit" class="btn btn-default">
				<i class="fa fa-btn fa-plus"></i>Add Bug
			    </button>
			</div>
		    </div>
		</form>
	    </div>
	</div>




<?php if (Auth::check()) :?>
  <!-- Current Bugs -->
  	    @if (count($bugs) > 0)
  		<div class="panel panel-default">
  		    <div class="panel-heading">
  			Current Bugs
  		    </div>

  		    <div class="panel-body">
  			<table class="table table-striped bug-table">
  			    <thead>
  				<th>Name</th>
          <th>Address</th>
          <th>Title</th>
          <th>Body</th>
          <th>Image</th>
  				<th>&nbsp;</th>
  			    </thead>
  			    <tbody>
            <?php $i=0;?>
  				@foreach($bugs as $bug)

  				    <tr class="item-done clickable" data-toggle="collapse"  href="<?php echo "#collapse".$i?>">
  					<td class="col-md-2"><div>{{ $bug->name }}</div></td>
            <td class="col-md-3"><div>{{ $bug->address }}</div></td>
            <td class="col-md-2"><div>{{ $bug->title }}</div></td>
            <td class="col-md-2"><div>{{ $bug->body }}</div></td>
            <td class="col-md-3">
              <div>
                <?php if ($bug->filename!="") :
                  $pathpath=pathinfo($bug->filename);?>
                  <img border="0" src="{{ asset( "img/".$pathpath['filename'].'/'.$bug->filename)}}" width="128" height="128" alt="<?php echo $bug->filename;?>">
                <?php endif; ?>
              </div>
            </td>

            <!-- <tr> -->
              <!-- Bug Name -->
              <!-- <td class="table-text">
                <div>{{ $bug->name }}</div>
              </td> -->

              <!-- Delete Button -->
              <td>
                <form action="{{ url('bug/'.$bug->id) }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}

                  <button type="submit" class="btn btn-danger">
                    <i class="fa fa-trash"></i> Delete
                  </button>
                </form>
              </td>
            </tr>
            <tr>
                <!-- ここのstleは!importantを使ってcssファイルにした方が良い -->
                <td colspan="2" style="padding:0px">

                    <div id="<?php echo "collapse".$i?>" class="collapse">
                        <ol type="a" style="background-color:white;">
                            <li><a>メニュー１</a></li>
                            <li><a>メニュー２</a></li>
                            <li><a>メニュー３</a></li>
                        </ol>
                    </div>
                </td>
            </tr>

  					<td>&nbsp;</td>
            <?php $i++;?>
  				    <!-- </tr> -->
  				@endforeach
  			    </tbody>
  			</table>
  		</div>
    </div>
  	    @endif
      <?php endif; ?>

    </div>
  </div>
@endsection


<!-- <div class="panel-group" id="test" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#test" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          コンテンツ１のトグルボタン
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        コンテンツ１
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#test" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          コンテンツ２のトグルボタン
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
        コンテンツ２
      </div>
    </div>
  </div>
</div> -->



<!--
    <tbody>
    <tr class="item-done clickable" data-toggle="collapse" data-target="#accordion5">
        <td>このカラムをクリックするとメニューを出し入れできる。</td>
        <td>9m25s</td>
    </tr>
    <tr>
        <!- ここのstleは!importantを使ってcssファイルにした方が良い ->
        <td colspan="2" style="padding:0px">
            <div id="accordion5" class="collapse">
                <ol type="a" style="background-color:white;">
                    <li><a>メニュー１</a></li>
                    <li><a>メニュー２</a></li>
                    <li><a>メニュー３</a></li>
                </ol>
            </div>
        </td>
    </tr>
  </tbody>
  </table> -->
