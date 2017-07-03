function bbcwLoadVirtualExhibit(id,selector,show_title){

	jQuery.ajax({
		async:true,
		dataType:"json",
		success:function (data) {
			console.log(data.exhibit);
			var html;
			if (show_title){
				html=html+'<h3 class="bbcw-exhibit-title">'+data.exhibit.name+'<br /><span class="bbcw-exhibit-curator">Curated by '+data.exhibit.curator+'</span></h3>';
				html=html+'<p>'+data.exhibit.gloss+'</p>';
			}
			jQuery(selector).append(html);
			for (var i = 0; i < data.treasures.length; i++) {
				html='';
				console.log(data.treasures[i]._matchingData.TreasuresUsergals.comments);
				img=data.treasures[i].img;
				//clean up img data and make a path
				img=img.replace('#','');
				img=img.replace(' ','_');
				img_zm='https://cdn.bbcw.org/zoomify_slices/1/'+img+'/TileGroup0/0-0-0.jpg';
				//not using this one yet
				img_full='https://cdn.bbcw.org/collection_images/1/'+img;
				//console.log(img_zm);
				html=html+'<a href="https://collections.centerofthewest.org/view/'+data.treasures[i].slug+'">';
				html=html+'<div class="bbcw-exhibit-item" style="background-image: url(\''+img_zm+'\')">';
				html=html+'<div class="bbcw-exhibit-item-caption"><p>'+data.treasures[i]._matchingData.TreasuresUsergals.comments+'</p></div>';
				html=html+'</div></a><!-- bbcw-exhibit-item -->';
				jQuery(selector).append(html);
			}
			jQuery(selector).append('<div style="clear:both"></div>');
		},
		type:"GET",
		url: "https://collections.centerofthewest.org/exhibit/"+id+".json"
		});
		
}
/*
$css_img='zoomify_slices/1/'.str_replace(' ','_',str_replace('#','',$treasure->img)).'/TileGroup0/0-0-0.jpg';
else $css_img='img/non.jpg';
?>
<div class="img-block" style="background-image: url('https://cdn.bbcw.org/<?=$css_img?>');">

*/