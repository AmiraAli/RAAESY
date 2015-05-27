@extends('app')
@section('content')
    <h1>Article Show</h1>

    
        <div class="form-group">
            <label for="subject" class="col-sm-2 control-label">SUBJECT</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="subject" placeholder={{$article->subject}} readonly>
            </div>
        </div>

        <div class="form-group">
            <label for="body" class="col-sm-2 control-label">BODY</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="subject" placeholder={{$article->body}} readonly>
            </div>
        </div>
        
          <div class="form-group">
            <label for="isshow" class="col-sm-2 control-label">isshow!?</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="isshow" placeholder={{$article->isshow}} readonly>
            </div>
        </div>

         <div class="form-group">
            <label for="category" class="col-sm-2 control-label">Category</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="category" placeholder={{$article->category->name}} readonly>
            </div>
        </div>

         <div class="form-group">
            <label for="isshow" class="col-sm-2 control-label">isshow!?</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="isshow" placeholder={{$article->user->name}} readonly>
            </div>
        </div>
        
    </form>
@endsection