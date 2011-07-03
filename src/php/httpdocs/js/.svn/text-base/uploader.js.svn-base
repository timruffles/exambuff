$(document).ready(function(){
	var loadCheck;
	var uploadedFiles = [];
	var pages = 1;
	var deleteTag = '<span class="delete"><a href="#" id="delete">Delete</a></span>';
	var delUrl = base_url+'user/upload/delete';	
	var upUrl = base_url+'user/upload/pageUp';
	var downUrl = base_url+'user/upload/pageDown';	
	var pageUploads = new Array();
	/**
	 * file upload event - sets up iFrame upload target, submits file form to upload. Saves
	 * file name in uploadedFiles, which is an array of iframe names with their related file.
	 * Sets up a loadcheck timer to check when upload has completed
	 */ 
	$('input.upload').change(function(event){
		pages++;
		var newFrameName = 'upload_target_'+pages;
		uploadMsg(pages);
		$('#iframes').append('<iframe id="'+newFrameName+'" name="'+newFrameName+'"></iframe>');
		$(event.target).parent().parent().attr('target',newFrameName);
		$(event.target).parent().parent().submit();	
		uploadedFiles[newFrameName] = $(event.target).attr('value');		
		var loadcheck = setTimeout(function(){checkLoad(newFrameName,pages)},500);
		$(this).attr('value','');
	});	
	
	/**
	 * delete page
	 */ 
	$('#delete a').click(function(event){
		event.preventDefault();
		
		var pageNum = $('#delete').parent().parent().find('span.pageNum').html();
		
		var liToDelete = $('#delete').parent().parent();
		$('#controls').attr('id','controlsHidden');
		$('#controlsHidden').prependTo('#pagesPresent');
		$('#controlsHidden').attr('style','display:none');		
		$.post(delUrl,{pageNum:pageNum},function(){
			$(liToDelete).remove();
			$('#controlsHidden').attr('id','controls');
			renumberPages();
			checkProgress();});
		return false;
		
	});	
	
	/**
	 * move controls to highlighted page
	 */ 
	$('#pagesPresent li').hover(function(e) {		
		
			$('#controls').prependTo($(e.currentTarget));
			$('#controls').attr('style','display:block;float:right');
		
	},function(e){		
		$('#controls').attr('style','display:none');
	});
	
	/**
	 * Move page up
	 */ 
	$('#up a').click(function(event) {
		event.preventDefault();		
		var pageNum = $('#controls').parent().find('span.pageNum').html();	
		$.post(upUrl,{pageNum:pageNum},function(){
			if(numberOfPages()>1) {
		
				
				if(pageNum != numberOfPages()) {				
					var pageToSwap = $('#controls').parent();
					var withThisPage = $(pageToSwap).next();
					$(pageToSwap).insertAfter(withThisPage);
					
					renumberPages();					
				}
			}
		});
	});	
	
	/**
	 * Move page down
	 */
	$('#down a').click(function(event) {
		event.preventDefault();			
		var pageNum = $('#controls').parent().find('span.pageNum').html();
		$.post(downUrl,{pageNum:pageNum},function(){
			if(numberOfPages()>1) {
		
				
				if(pageNum != 1) {				
					var pageToSwap = $('#controls').parent();
					var withThisPage = $(pageToSwap).prev();
					$(pageToSwap).insertBefore(withThisPage);
					
					renumberPages();					
				}
			}
		});
	});	
	/**
	 * Counts the current number of pages uploaded
	 */
	function numberOfPages() {
		return $('#pagesPresent').find('li').length;
	}
	/**
	 * Renumber pages to fill gaps
	 */
	function renumberPages() {
		var pageLis = $('#pagesPresent').find('li').each(function(index,ele){var pn = index+1;
			$(ele).children('span.pageNum').html(pn);
		});		
	}
	/**
	 * Error message if file type is wrong
	 */
	function wrongType(iFrameName,page) {
		var splitByDot = uploadedFiles[iFrameName].split('.');
		var illegalType = splitByDot[splitByDot.length-1];
		var errorMsg = uploadedFiles[iFrameName]+' could not be uploaded, as it was a .'+illegalType+' file. Please upload .jpg files';
		uploadFail(page,errorMsg);
	}
	function noFile(iFrameName,page) {
		var errorMsg = 'There was an error uploading '+uploadedFiles[iFrameName]+', please retry';
		uploadFail(page,errorMsg);
	}
	function tooLarge(iFrameName,page) {
		var errorMsg = uploadedFiles[iFrameName]+' was too large. Please resize and retry';
		uploadFail(page,errorMsg);
	}
	function checkProgress() {
		var pagesPres = $('#pagesPresent').children('li').length;
		var nxt = $('table.progressBar tr td:eq(1)');
		if(pagesPres != false) {
			if($('table.progressBar tr td:eq(1)').children('a').length !== 0) return;
			$('table.progressBar tr td:eq(0)').addClass('complete');
			var url = nxt.children('span.url').html();
			var txt = nxt.children('span:eq(1)').html();
			nxt.html('<a href="'+url+'">'+txt+'</a>');
		} else {
			if($('table.progressBar tr td:eq(1)').children('span').length == 2) return;
			$('table.progressBar tr td:eq(0)').removeClass('complete');
			var url = nxt.children('a').attr('href');
			var txt = nxt.children('a').html();
			nxt.html('<span class="url">'+url+'</span><span>'+txt+'</span>');
		}
	};
	/**
	 * Inform user that upload has started
	 */
	function uploadMsg(page) {		
		uploadMsgString = 'Attempting to upload '+$('input.upload').attr('value')+', please wait';
		$('div.info').append('<p><span class="for" style="display:none">'+page+'</span>'+uploadMsgString+'</p>');
		$('div.info').removeClass('no-messages');
	}
	/**
	 * Inform user of successful upload
	 */
	function uploadSuccess(page,element) {
		removeUploadInfo(page);		
		uploadCheckpointString = 'Successfully uploaded '+uploadedFiles[element];
		$('div.checkpoint').prepend('<p><span class="for" style="display:none">'+page+'</span>'+uploadCheckpointString+'</p>');
		$('div.checkpoint').removeClass('no-messages');
		checkProgress();		
	}
	function removeUploadInfo(page) {
		var info = $('div.info');
		var numCh = info.children('p').length;
		info.find('p').each(function(){
			if($(this).children('span.for').html()==page) {
				$(this).remove();
			}				
		});
		if(numCh===1) {
			info.addClass('no-messages');
		}
	}
	/**
	 * Inform user of failed upload
	 */
	function uploadFail(page,reason) {
		removeUploadInfo(page);
		$('div.error').prepend('<p><span class="for" style="display:none">'+page+'</span>'+reason+'</p>');
		$('div.error').removeClass('no-messages');
		checkProgress();	
	}
	/**
	 * Check the iframe relating to a page number for results
	 */
	function checkLoad(iFrameName,page) {	
		
		var resultText = $('#'+iFrameName).contents().text();			
		
		var results = parseResults(resultText.ltrim());
		var resultVar = results['result'];
		
		//alert('checkLoad'+iFrameName);
		
		switch (resultVar) {
			case 'SUCCESSFUL':
				var nextPageNum = $('#pagesPresent').children().length+1;		
				var newLi = $('<li></li>').html('<span class="pageNum">'+nextPageNum+'</span>'+uploadedFiles[iFrameName])
                                          .hover
												(
													function(e) 
													{		
														$('#controls').prependTo($(e.currentTarget));
														$('#controls').attr('style','display:block;float:right');
													},
													function(e)
													{		
														$('#controls').attr('style','display:none;overflow:hidden;')
													}
												);	
				$('#pagesPresent').append(newLi);
				$('#pagesPresent > li:last').effect("highlight",{},1000);
				uploadSuccess(pages,iFrameName);
			break;
			case 'NO_FILE':
				noFile(iFrameName,page);
			break;
			case 'WRONG_TYPE':
				wrongType(iFrameName,page);
			break;
			case 'TOO_LARGE':
				tooLarge(iFrameName,page);
			break;
			default:
				var loadcheck = setTimeout(function(){checkLoad(iFrameName,page)},500);
			break;
		}	
	}	
	/**
	 * Function to read results from iframe, which are URL encoded
	 */
	function parseResults(resultString) {	
		// split by &
		var resArray = resultString.split('&');	
		var results = new Array();
		for (var  i=0; i<resArray.length;i++) {
			var keyVal = resArray[i].split('=');
			var key = keyVal[0];
			var val = keyVal[1];
			results[key] = val;	
		}		
		return results;
	}	
	String.prototype.ltrim = function() {
		return this.replace(/^\s+/,"");
		}
	//alert('no errors');
});

