<?php

use App\Bug;
use Illuminate\Http\Request;
use App\Mail\ReportShipped;
//use App\Mail;

Route::get('/', function () {
  $bugs = Bug::orderBy('created_at', 'asc')->get();

  return view('bugs', [
      'bugs' => $bugs
  ]);
});

//Route::get('email/create', 'EmailController@create');

Route::post('/bug', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'address' => 'nullable|max:255',
        'title' => 'nullable|max:10000',
        'body' => 'nullable|max:255',
        'file'=>'nullable|image|max:102400'
    ]);

    if($validator->fails()){
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $bug = new Bug;
    $bug->name = $request->name;
    $bug->address = $request->address;
    $bug->title = $request->title;
    $bug->body = $request->body;

    // if($request->hasFile('file')){
    //   // $OldDestinationPath = "storage/img/temp";
    //   $NewDestinationPath = "storage/img/".$bug->id;
    //   echo $NewDestinationPath;
    //   mkdir( $NewDestinationPath );
    //   // $request->file('photo')->move($OldDestinationPath,$NewDestinationPath);
    //   $request->file('file')->move($NewDestinationPath);
    //   $bug->filename = $NewDestinationPath;
    // }
    if($request->hasFile('file')){
      $path = "app/".$request->file('file')->store('img/tmp');
      $bug->filename = basename($path);
      $path2 = pathinfo($path);
      $path3="/app/img/".$path2['filename'];
      mkdir("../storage/".$path3);
      rename("../storage/".$path,"../storage/".$path3."/".$path2['basename']);
    }
    $bug->save();

    $sendToList=array();
    $sendData="";
    $addresslist = fopen("../resources/views/emails/sendaddress/addresslist.php", "r");
    while ($List = fgets($addresslist)) {
      $List = str_replace(array("\r\n", "\r", "\n"), '', $List);
      if($List=="") break;
      if(filter_var($List, FILTER_VALIDATE_EMAIL)){
        $sendToList[]=$List;
      }
    }
    fclose($addresslist);

    foreach ($sendToList as $sendTo) {
      Mail::to($sendTo)->send(new ReportShipped($sendData));
    }


    return redirect('/');
});

Route::delete('/bug/{bug}', function (Bug $bug) {
  if($bug->filename!=""){
    $pathpath=pathinfo($bug->filename);
    $dir="../storage/app/img/".$pathpath['filename'];
    if ($handle = opendir("$dir")) {
      while (false !== ($item = readdir($handle))) {
        if ($item != "." && $item != "..") {
          if (is_dir("$dir/$item")) {
            remove_directory("$dir/$item");
          } else {
            unlink("$dir/$item");
          }
        }
      }
      closedir($handle);
      rmdir($dir);
    }
  }

  $bug->delete();

  return redirect('/');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
