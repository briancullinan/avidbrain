<div class="crop-container">

    <h1>Crop Your Photo</h1>


    <div class="crop-container-more">
        <p>Please crop your photo for your profile. Only cropped photos will be approved.</p>


        <div>

            <input type="hidden" class="imageWidth" value="<?php echo $app->img->width(); ?>" />
            <input type="hidden" class="imageHeight" value="<?php echo $app->img->height(); ?>" />


            <input type="hidden" class="pageWidth" />
            <input type="hidden" class="pageHeight" />

            <div id="newCropbox" >
                <img src="/image/photograph/<?php echo $app->actualuser->username; ?>" widt="<?php echo $app->img->width(); ?>" height="<?php echo $app->img->height(); ?>" />
            </div>


        </div>


        <form id="newCropform" action="<?php echo $app->actualuser->url; ?>" method="post">
        	<input type="hidden" id="x" name="crop[x]" />
        	<input type="hidden" id="y" name="crop[y]" />
        	<input type="hidden" id="w" name="crop[w]" />
        	<input type="hidden" id="h" name="crop[h]" />
        	<?php if(isset($app->imgwidth)): ?>
        		<input type="hidden" id="cropwidth" name="crop[fullwidth]" value="<?php echo $app->imgwidth; ?>" />
        	<?php endif; ?>

        	<input type="hidden" name="crop[target]" value="crop"  />
        	<input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">

        	<button type="submit" class="btn btn-success">
        		Crop Photo
        	</button>
        </form>
    </div>

    <form method="post" action="<?php echo $app->actualuser->url; ?>/my-photos/crop-photo" id="resizecrop">
        <input type="hidden" name="resizecrop[target]" value="resizecrop"  />
        <input type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
    </form>


</div>


<style type="text/css">
#newCropform{
    margin-top:10px;
}
.crop-container{
	margin-top: 29px;
}
.crop-container-more{
    padding: 20px;
}
</style>


<script type="text/javascript">

	$(document).ready(function() {

        function newupdateCoords(c){
            $('#x').val(c.x);
            $('#y').val(c.y);
            $('#w').val(c.w);
            $('#h').val(c.h);
        };

        var imageload = $('#newCropbox img');
        imageload.load(function(){
            $('#newCropbox').Jcrop({
                aspectRatio: 1/1,
    			onSelect: newupdateCoords,
    			allowSelect:false,
    			bgColor:'black',
    			bgOpacity: .5,
    		    setSelect: [ 172, 71, 322, 271 ],
    	        minSize: [210]
            });


            var pageWidth = $('.crop-container-more').width();
            var pageHeight = $('.crop-container-more').outerHeight();
            var imageWidth = $('.imageWidth').val();
            var imageHeight = $('.imageHeight').val();
            $('.pageWidth').val(pageWidth);
            $('.pageHeight').val(pageHeight);

            data = {
                'pageWidth':pageWidth,
                'pageHeight':pageHeight,
                'imageWidth':imageWidth,
                'imageHeight':imageHeight
            }

            if(data.imageWidth > data.pageWidth){
                $('#resizecrop').append('<input type="text" name="resizecrop[width]" value="'+data.pageWidth+'" />');
                $('#resizecrop').append('<input type="text" name="resizecrop[height]" value="'+data.pageHeight+'" />');
                $('#resizecrop').submit();
            }
        });
	});

</script>
