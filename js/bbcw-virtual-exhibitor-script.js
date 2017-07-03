function bbcwLoadVirtualExhibit(id,selector,show_title,limit){

	jQuery.ajax({
		async:true,
		dataType:"json",
		success:function (data) {
			bbcwWriteJSONData(data,selector,show_title,id,'exhibit');
		},
		error:function(){
			jQuery(selector).append('<p class="bbcw-exhibit-error">Error fetching virtual exhibit '+id+'. Please check the number and try again.</p>');
		},
		type:"GET",
		url: "https://collections.centerofthewest.org/exhibit/"+id+".json?limit="+limit
		});
		
}

function bbcwLoadLovesList(handle,selector,show_title,limit){

	jQuery.ajax({
		async:true,
		dataType:"json",
		success:function (data) {
			bbcwWriteJSONData(data,selector,show_title,handle,'loved');
		},
		error:function(){
			jQuery(selector).append('<p class="bbcw-exhibit-error">Error fetching virtual exhibit '+id+'. Please check the number and try again.</p>');
		},
		type:"GET",
		url: "https://collections.centerofthewest.org/loved/"+handle+".json?limit="+limit
		});
		
}

//thank you StackOverflow!
function truncate( n, useWordBoundary ){
    if (this.length <= n) { return this; }
    var subString = this.substr(0, n-1);
    return (useWordBoundary 
       ? subString.substr(0, subString.lastIndexOf(' ')) 
       : subString) + "&hellip;";
};

function bbcwWriteJSONData(data,selector,show_title,id,type){
	//console.log(data.exhibit);
	var html='';
	if (data.exhibit){
		if (show_title){
			html=html+'<h3 class="bbcw-exhibit-title">'+data.exhibit.name+'<br /><span class="bbcw-exhibit-curator">Curated by '+data.exhibit.curator+'</span></h3>';
			if (data.exhibit.gloss) html=html+'<p>'+data.exhibit.gloss+'</p>';
		}
	}
	else{
		if (type=='loved'){
			if (show_title){
				html=html+'<h3 class="bbcw-exhibit-title">'+id+'\'s Loved Items</h3>';
			}
		}
	}
	jQuery(selector).append(html);
	var maxOffset=data.treasures.length-1;
	for (var i = 0; i < data.treasures.length; i++) {
		var comment='';
		if (data.treasures[i]._matchingData.TreasuresUsergals && data.treasures[i]._matchingData.TreasuresUsergals.comments){
			comment=data.treasures[i]._matchingData.TreasuresUsergals.comments;
		}
		else{
			if (data.treasures[i].gloss) comment=data.treasures[i].gloss;
			else comment=data.treasures[i].synopsis;
		}
		comment=truncate.apply(comment, [130, true]); 
		html='';
		//console.log(data.treasures[i]._matchingData.TreasuresUsergals.comments);
		img=data.treasures[i].img;
		//clean up img data and make a path
		img=img.replace('#','');
		//need regex to replace spaces
		img=img.replace(/ /g,"_");
		img_zm='https://cdn.bbcw.org/zoomify_slices/1/'+img+'/TileGroup0/0-0-0.jpg';
		//not using this one yet
		img_full='https://cdn.bbcw.org/collection_images/1/'+img;
		//console.log(img_zm);
		html=html+'<a href="https://collections.centerofthewest.org/view/'+data.treasures[i].slug+'?offset='+i+'&maxOffset='+maxOffset+'&'+type+'='+id+'">';
		html=html+'<div class="bbcw-exhibit-item" style="background-image: url(\''+img_zm+'\')">';
		html=html+'<div class="bbcw-exhibit-item-caption"><p>'+comment+'</p></div>';
		html=html+'</div></a><!-- bbcw-exhibit-item -->';
		jQuery(selector).append(html);
	}
	jQuery(selector).append('<div style="clear:both"></div>');
	jQuery(selector).append('<div class="bbcw-exhibit-footer"><p>Virtual Exhibit courtesy of <a href="https://collections.centerofthewest.org">https://collections.centerofthewest.org</a></p></div>');
	
}