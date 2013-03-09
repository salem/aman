if(typeof AMAN === 'object'){
	
	AMAN.namespace('Aman.Startex.Utility');
	
	Aman.Startex.Utility = function(){
		
	};
	
	Aman.Startex.Utility.FlateDataTree = function(flatdata){
		var depth = new Array();
		var nod = new Object();
		var count = -1;
		var treeByLevelCollection = new Array();
		//Get depth
		$.each(flatdata,function(index, row){
			if(row.parentID == 0 || row.parentID == ''){
				depth.push(row.level);
				count++;
			}
			else{
				if(row.level != depth[count]){
					depth.push(row.level);
					count++;
				}
			}
		});
		depth.reverse();
		//
		var storeLevel = new Array();
		var previous = new Array();
		count=0;
		$.each(depth, function(index1, level){
			previous = new Array();
			$.each(storeLevel, function(index2, o){
				previous.push(o);
			});
			storeLevel = new Array();
			$.each(flatdata, function(index3, row1){
				if(row1.level == level) {
					nod = new Object();
					nod.ID = row1.ID;
					nod.key = "id."+row1.ID;					
					nod.parentID = row1.parentID;
					nod.title = row1.name;
					nod.groupName = row1.level;
					nod.lft = row1.lft;
					nod.rht = row1.rht;					
					nod.clientID = row1.clientID;
					nod.formatID = row1.formatID;
					nod.children = [];
					if(depth.length>level){
						nod.isFolder = true;
					}
					$.each(previous, function(index4, nodObj){
						if(nodObj.parentID == nod.ID)
							nod.children.push(nodObj);
					});
					storeLevel.push(nod);
				}
			});
			
			treeByLevelCollection[index1] = {children: storeLevel};
		});
		treeByLevelCollection.reverse();
		return {tree: nod, treeByLevel: treeByLevelCollection};
	};
	Aman.Startex.Utility.FlateDataTreeWithCheckBox = function(flatdata){
		var depth = new Array();
		var nod = new Object();
		var count = -1;
		var treeByLevelCollection = new Array();
		//Get depth
		$.each(flatdata,function(index, row){
			if(row.parentID == 0 || row.parentID == ''){
				depth.push(row.level);
				count++;
			}
			else{
				if(row.level != depth[count]){
					depth.push(row.level);
					count++;
				}
			}
		});
		depth.reverse();
		//
		var storeLevel = new Array();
		var previous = new Array();
		count=0;
		$.each(depth, function(index1, level){
			previous = new Array();
			$.each(storeLevel, function(index2, o){
				previous.push(o);
			});
			storeLevel = new Array();
			$.each(flatdata, function(index3, row1){
				if(row1.level == level) {
					nod = new Object();
					nod.ID = row1.ID;
					nod.key = "id."+row1.ID;					
					nod.parentID = row1.parentID;
					nod.title = row1.name;
					nod.groupName = row1.level;
					nod.lft = row1.lft;
					nod.rht = row1.rht;					
					nod.clientID = row1.clientID;
					nod.formatID = row1.formatID;
					nod.children = [];
					if(depth.length>level){
						nod.isFolder = true;
					}
					
					if(row1.counter != null && row1.shopID != null){
						nod.shopID = row1.shopID;
						if(row1.counter>0) {
							nod.counter = row1.counter;
							nod.select = true;
							nod.title = nod.title + ' (<strong style="color: red">'+row1.counter+'</strong>)';
						}
					}
					else{
						nod.select = false;
					}

					$.each(previous, function(index4, nodObj){
						if(nodObj.parentID == nod.ID)
							nod.children.push(nodObj);
					});
					storeLevel.push(nod);
				}
			});
			
			treeByLevelCollection[index1] = {children: storeLevel};
		});
		treeByLevelCollection.reverse();
		return {tree: nod, treeByLevel: treeByLevelCollection};
	};
	
	/*
	Aman.Startex.Utility.GetSelectedLocation = function(teVo, property){
		
		$.each(teVo.children, function(index, obj){
			if(obj.children.length != 0){
				Aman.Startex.Utility.GetSelectedLocation(obj, property);
			}
			else if(obj.counter != null && obj.counter>0 && obj.select== true){
				obj.selected = true;
				Utilities.stack.push(obj);
			}
			else if(obj.state=="unchecked" && requestedProperty=="unselected"){
				obj.selected = false;
				Utilities.stack.push(obj);
			}
			else if(requestedProperty == "both"){
				obj.selected = (obj.state=="checked")?true:false;
				Utilities.stack.push(obj);
			}
		});
	};
	
	*/
	Aman.Startex.Utility.MySqlToEnglishDate = function(date){
		var temp = date.split('-');
		return temp[2] +"/" + temp[1] + "/" + temp[0];
		
	};
	
	Aman.Startex.Utility.EnglishToMySqlDate = function(date){
		var temp = date.split('/');
		return temp[2] +"/" + temp[1] + "/" + temp[0];
	};
};