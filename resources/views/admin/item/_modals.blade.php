

{{-- 上传文件 --}}
<div class="modal fade" id="modal-file-upload">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action=" {{URL('/admin/upload/file')}} " class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
    
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">上传新文件</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="file" class="col-sm-3 control-label">
                            文件
                        </label>
                        <div class="col-sm-8">
                            <input type="file" id="file" name="file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        取消
                    </button>
                    
                     <a id="start_upload"  href="javascript:;">上传</a>
                    <!--
                    <button type="submit" class="btn btn-primary">
                        上传文件
                    </button>-->
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 浏览图片 --}}
<div class="modal fade" id="modal-image-view">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    ×
                </button>
                <h4 class="modal-title">图片浏览</h4>
            </div>
            <div class="modal-body">
                <img id="preview-image" src="x" class="img-responsive">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    取消
                </button>
                
               
            </div>
        </div>
    </div>
</div>