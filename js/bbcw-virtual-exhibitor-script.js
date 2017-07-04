/* 
id/handle, type, layout, selector,limit,title(bool),footer(bool),target(bool),method(append or replace)
the integer parsing was dealt with PHP before, so we'll trust it
*/
function bbcwLoadVirtualExhibit(id,type,layout,selector,limit,show_title,footer,target,method){
	var collectionsURL;
	if (type=='loved') collectionsURL="https://collections.centerofthewest.org/loved/"+id+".json?limit="+limit;
	else collectionsURL="https://collections.centerofthewest.org/exhibit/"+id+".json?limit="+limit;
	
	jQuery.ajax({
		async:true,
		dataType:"json",
		success:function (data) {
			bbcwWriteJSONData(id,type,layout,selector,show_title,footer,target,data,method);
		},
		error:function(){
			jQuery(selector).append('<p class="bbcw-exhibit-error">Error fetching '+type+' data for '+id+'. Please check the number and try again.</p>');
		},
		type:"GET",
		url: collectionsURL
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

function bbcwWriteJSONData(id,type,layout,selector,show_title,footer,target,data,method){
	//console.log(data.exhibit);
	//layout is validated by php, so we trust this to work
	var bbcwLayoutClass='bbcw-exhibit-'+layout;
	var new_window='';
	if (target) new_window=' target="_blank" ';
	var html='';
	if (data.exhibit){
		if (show_title){
			html=html+'<h3 class="bbcw-exhibit-title '+bbcwLayoutClass+'">'+data.exhibit.name+'<br /><span class="bbcw-exhibit-curator '+bbcwLayoutClass+'">Curated by '+data.exhibit.curator+'</span></h3>';
			if (data.exhibit.gloss) html=html+'<p>'+data.exhibit.gloss+'</p>';
		}
	}
	else{
		if (type=='loved'){
			if (show_title){
				html=html+'<h3 class="bbcw-exhibit-title '+bbcwLayoutClass+'">'+id+'\'s Loved Items</h3>';
			}
		}
	}

	if (method=='replace') jQuery(selector).html(html);
	else jQuery(selector).append(html);
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
		html=html+'<div class="bbcw-exhibit-item-container '+bbcwLayoutClass+'">';
		html=html+'<a class="bbcw-exhibit-link '+bbcwLayoutClass+'" '+new_window+'href="https://collections.centerofthewest.org/view/'+data.treasures[i].slug+'?offset='+i+'&maxOffset='+maxOffset+'&'+type+'='+id+'">';
		html=html+'<div class="bbcw-exhibit-item '+bbcwLayoutClass+'" style="background-image: url(\''+img_zm+'\')">';
		//if grid layout put the caption inside the div
		if (layout=='grid'){
			html=html+'<div class="bbcw-exhibit-item-caption '+bbcwLayoutClass+'"><p>'+comment+'</p></div>';
		}
		html=html+'</div>';
		//list put div outside, this could just be done with CSS too...
		if (layout=='list'){
			html=html+'<div class="bbcw-exhibit-item-caption '+bbcwLayoutClass+'"><p>'+comment+'</p></div>';
		}
		html=html+'</a><!-- bbcw-exhibit-item -->';
		html=html+'</div><!-- bbcw-exhibit-item-container -->';
		jQuery(selector).append(html);
	}
	jQuery(selector).append('<div style="clear:both"></div>');
	if (footer){
		jQuery(selector).append('<div class="bbcw-exhibit-footer '+bbcwLayoutClass+'"><p>Find something to love at <a href="https://collections.centerofthewest.org">https://collections.centerofthewest.org</a></p></div>');
	}
	
}