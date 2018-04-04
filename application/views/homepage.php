<script type ='text/javascript'>
var str = 0;	
var dex = 0;	
var int = 0;	

function drag(target, event) {
    event.dataTransfer.setData("itemID", target.id);
    event.dataTransfer.setData("itemCategory", target.getAttribute("data-category"));
    event.dataTransfer.setData("itemStr", target.getAttribute("data-str"));
    event.dataTransfer.setData("itemDex", target.getAttribute("data-dex"));
    event.dataTransfer.setData("itemInt", target.getAttribute("data-int"));
}

function drop(target, event) {
    var itemID = event.dataTransfer.getData("itemID");
    var itemCategory = event.dataTransfer.getData("itemCategory");
    var itemStr = event.dataTransfer.getData("itemStr");
    var itemDex = event.dataTransfer.getData("itemDex");
    var itemInt = event.dataTransfer.getData("itemInt");
    // only allow dropping if correct item
    var slotCategory = target.getAttribute("data-category"); 
    if (itemCategory != slotCategory)
    	return;

    var origImg = document.getElementById(itemID);
    var newItem = origImg.cloneNode(true);

    var oldItem = target.firstElementChild;
    var oldItemID = oldItem.id;
    str -= parseInt(oldItem.getAttribute("data-str"));
    dex -= parseInt(oldItem.getAttribute("data-dex"));
    int -= parseInt(oldItem.getAttribute("data-int"));
    target.innerHTML = "";
    
    //will have problems with cloned ids
    newItem.setAttribute("id", oldItemID);
    str += parseInt(newItem.getAttribute("data-str"));
    dex += parseInt(newItem.getAttribute("data-dex"));
    int += parseInt(newItem.getAttribute("data-int"));
    target.appendChild(newItem);
    updateStats();
}

function updateStats() {
	var strField = document.getElementById("strField");
	strField.innerHTML = str;
	var dexField = document.getElementById("dexField");
	dexField.innerHTML = dex;
	var intField = document.getElementById("intField");
	intField.innerHTML = int;
}

function fillEmptySlot(slotID)
{
	// do a lookup of slotID to slot img
	$.getJSON("slots/" + slotID, function(data){
		var slot = data[0];

		var emptySlot = document.createElement("img");
	    emptySlot.setAttribute("id", slot.id);
		emptySlot.setAttribute("src", "./assets/img/" + slot.name + ".png");
		emptySlot.setAttribute("alt", "");
		emptySlot.setAttribute("data-str", 0);
		emptySlot.setAttribute("data-dex", 0);
		emptySlot.setAttribute("data-int", 0);

		var oldItemRoot = document.querySelector("." + slotID);
		var oldItem = oldItemRoot.firstElementChild;
	    str -= parseInt(oldItem.getAttribute("data-str"));
	    dex -= parseInt(oldItem.getAttribute("data-dex"));
	    int -= parseInt(oldItem.getAttribute("data-int"));
	    oldItemRoot.innerHTML = "";
		oldItemRoot.appendChild(emptySlot);
	    updateStats();
	});
}

function changePreset() {
    var presetDropdown = document.getElementById("presetDropdown");
	var presetId = presetDropdown.options[presetDropdown.selectedIndex].id;
	$.getJSON("presets/" + presetId, function(data){
		var items = {};
        $.each(data[0], function(key, val)
        {        	
			if (key != "id" && key != "name" && val != ".")
				items[key] = val;
			if (val == ".")
				fillEmptySlot(key);
        });
        $.each( items, function( key, val ) {
			$.getJSON("singleItem/" + val, function(itemData){
				var item = itemData[0];
				// apparently jQuery can see key var even tho not passed in here
				var oldItemRoot = document.querySelector("." + key);
				var oldItem = oldItemRoot.firstElementChild;
			    str -= parseInt(oldItem.getAttribute("data-str"));
			    dex -= parseInt(oldItem.getAttribute("data-dex"));
			    int -= parseInt(oldItem.getAttribute("data-int"));
			    oldItemRoot.innerHTML = "";
			    
				var newItem = document.createElement("img");
			    newItem.setAttribute("id", key);
				newItem.setAttribute("src", "./assets/img/" + item.id + ".png");
				newItem.setAttribute("alt", item.id);
				newItem.setAttribute("data-str", item.str);
				newItem.setAttribute("data-dex", item.dex);
				newItem.setAttribute("data-int", item.int);

			    str += parseInt(newItem.getAttribute("data-str"));
			    dex += parseInt(newItem.getAttribute("data-dex"));
			    int += parseInt(newItem.getAttribute("data-int"));
			    oldItemRoot.appendChild(newItem);
			    updateStats();
			});
		});
    });
}

/* Load/Unloads the homepage inventory. */
function openInventoryTab(event, tabName) {
    // Declare all variables
    var tabContent, tabButton;

    // Get all elements with class="tabContent" and hide them
    tabContent = document.getElementsByClassName("tabContent");
    for (var i = 0; i < tabContent.length; i++)
        tabContent[i].style.display = "none";

    tabButton = document.getElementsByClassName("tabButton");
    for (var i = 0; i < tabButton.length; i++)
        tabButton[i].className = tabButton[i].className.replace(" active", "");

    document.getElementById(tabName).style.display = "block";
    event.currentTarget.className += " active";
}

$().ready(function() {
	//dropdown is already populated in php

	//populate inv
	$.ajax({
		url: "/category/all",
		dataType: 'json',
		error: function( data ) {
			console.log( 'ERROR: ', data );
		},
		success: function( data ) {
			console.log( 'SUCCESS INV: ' );
			$.each( data, function( key, val ) {
				var item = document.createElement("img");
				item.setAttribute("id", val.id);
				item.setAttribute("src", "./assets/img/" + val.id + ".png");
				item.setAttribute("alt", val.id);
				item.setAttribute("draggable", "true");
				item.setAttribute("ondragstart", "drag(this, event)");
				item.setAttribute("data-category", val.category);
				item.setAttribute("data-str", val.str);
				item.setAttribute("data-dex", val.dex);
				item.setAttribute("data-int", val.int);

				var tabName = val.category + "Tab";
				var tab = document.getElementById(tabName);
				tab.appendChild(item);		
			});
		}
	});

	//populate placeholder slots
	$.ajax({
		url: "/slots/all",
		dataType: 'json',
		error: function( data ) {
			console.log( 'ERROR: ', data );
		},
		success: function( data ) {
			console.log( 'SUCCESS SLOTS: ' );
			$.each( data, function( key, val ) {
				var slot = document.createElement("div");
				slot.setAttribute("class", val.id);
				slot.setAttribute("data-category", val.category);
				slot.setAttribute("ondrop", "drop(this, event)");
				slot.setAttribute("ondragenter", "return false");
				slot.setAttribute("ondragover", "return false");

				var placeholderItem = document.createElement("img");
				placeholderItem.setAttribute("id", val.id);
				placeholderItem.setAttribute("src", "./assets/img/" + val.name + ".png");
				placeholderItem.setAttribute("data-str", val.str);
				placeholderItem.setAttribute("data-dex", val.dex);
				placeholderItem.setAttribute("data-int", val.int);

				slot.appendChild(placeholderItem);		
				var appendImageRoot = document.getElementById("slots");
				appendImageRoot.appendChild(slot);
			});
		}
	});
});

function updatePreset() 
{
	var helmetID = document.getElementById("helmet").alt;
	var chestID = document.getElementById("chest").alt;
	var gloveID = document.getElementById("glove").alt;
	var bootID = document.getElementById("boot").alt;
	var beltID = document.getElementById("belt").alt;
	var amuletID = document.getElementById("amulet").alt;
	var ringLeftID = document.getElementById("ring_left").alt;
	var ringRightID = document.getElementById("ring_left").alt;
	var weaponLeftID = document.getElementById("weapon_left").alt;
	var weaponRightID = document.getElementById("weapon_right").alt;
	var presetDropdown = document.getElementById("presetDropdown");
	var presetID = presetDropdown.options[presetDropdown.selectedIndex].id;
	var presetName = document.getElementById("newPresetName").value;
	if (presetName == "")
		presetName = presetDropdown.options[presetDropdown.selectedIndex].value;

	$.ajax({
        type: "POST",
        url: "/presets/update",
	    data : { id : presetID, name : presetName, helmet : helmetID, chest : chestID, glove : gloveID, boot : bootID, belt : beltID,  amulet : amuletID, ring_left : ringLeftID, ring_right: ringRightID, weapon_left : weaponLeftID, weapon_right : weaponRightID 
		},
        success: function (result) {
        	alert(result);
        	location.reload(); //preset list need to update
        }
	});
}

function createPreset() 
{
	var presetName = document.getElementById("newPresetName").value;
	//also checked on server side if client does something goofy
	if (presetName == "")
	{
		alert("Need a name for your new preset!")
		return;
	}
	var helmetID = document.getElementById("helmet").alt;
	var chestID = document.getElementById("chest").alt;
	var gloveID = document.getElementById("glove").alt;
	var bootID = document.getElementById("boot").alt;
	var beltID = document.getElementById("belt").alt;
	var amuletID = document.getElementById("amulet").alt;
	var ringLeftID = document.getElementById("ring_left").alt;
	var ringRightID = document.getElementById("ring_left").alt;
	var weaponLeftID = document.getElementById("weapon_left").alt;
	var weaponRightID = document.getElementById("weapon_right").alt;
	var newIndex = document.getElementById("presetDropdown").options.length; //length == 1 after last index
	var newPresetID = "pre" + newIndex;
	
	$.ajax({
        type: "POST",
        url: "/presets/create",
	    data : { id : newPresetID, name : presetName, helmet : helmetID, chest : chestID, glove : gloveID, boot : bootID, belt : beltID,  amulet : amuletID, ring_left : ringLeftID, ring_right: ringRightID, weapon_left : weaponLeftID, weapon_right : weaponRightID 
		},
		error: function( data ) {
			console.log( 'ERROR: ', data );
		},
        success: function (result) {
        	alert(result);
        	location.reload(); //preset list need to update
        }
	});
}

</script>
<style type="text/css">

	.imageWrapper {
	  position: relative;
	}	

	#chest {
		position: absolute;
		top: 200px;
		left: 247px;
	}

	#helmet {
		position: absolute;
		top: 100px;
		left: 251px;
	}

	#ring_left {
		position: absolute;
		top: 251px;
		left: 183px;
	}
	/*ring is 50x50, each slot is 50x50*/
	#ring_right {
		position: absolute;
		top: 251px;
		left: 368px;
	}

	#amulet {
		position: absolute;
		top: 193px;
		left: 368px;
	}

	#belt {
		position: absolute;
		top: 360px;
		left: 252px;
	}

	#glove {
		position: absolute;
		top: 312px;
		left: 135px;
	}

	#boot {
		position: absolute;
		top: 312px;
		left: 370px;
	}

	#weapon_left {
		position: absolute;
		top: 110px;
		left: 65px;
	}

	#weapon_right {
		position: absolute;
		top: 110px;
		left: 438px;
	}

	#inventoryBox {
		position: absolute;
		top: 80px;
		left: 600px;
		min-width: 51%; 

		border-style: double;
		border-radius: 5px;
		border-width: 5px;
		border-color: black;
	}

	#inventoryBox h3 {
		margin-left: 5%;
	}

	.tab button {
	    background-color: inherit;
	    float: left;
	    cursor: pointer;
	    padding: 14px 7px;
	}


	.tabContent {
	    display: none;
	}

	#statsBox {
		position: absolute;
		top: 220px;
		left: 780px;
		max-width: 20%; 

		border-style: double;
		border-radius: 5px;
		border-width: 5px;
		border-color: black;
		text-align: center;
	}

	#statsBox td {
		padding-left: 7px;	
		padding-right: 7px;
		max-width: 85px;
	}

	#savingControls {
		position: absolute;
		top: 220px;
		left: 1025px;
		max-width: 18%; 

		border-style: double;
		border-radius: 5px;
		border-width: 5px;
		border-color: black;
		text-align: left;
	}

	#savingControls button {
		background-color: inherit;
	    float: left;
	    cursor: pointer;
	    max-width: 90px;
	}

	#savingControls div {
	    background-color: inherit;
	    margin-left: 5px;
	    margin-bottom: 10px;
	}

</style>
<div class="POE_main">
	
		<h1 id="homepage-title">Welcome to Path of Exile Inventory Simulator!</h1>
		<div class="homepage-content">
            <div id="preset-dropdown">
            <select id="presetDropdown" class="round" onchange="changePreset();">
                {presets}
                  <option id={id} value={name}>{name}</option>
                {/presets}
            </select>
        	</div>
			<div id="statsBox">
				<table>
					<tr>					
						<h3>Stats</h3 >
					</tr>
					<tr>					
						<td>Strength</td>
						<td>Dexterity</td>
						<td>Intelligence</td>
					</tr>
					<tr>					
						<td id="strField">0</td>	
						<td id="dexField">0</td>
						<td id="intField">0</td>
					</tr>
				</table>
			</div>	
		    {savingcontrols}
            <div class="imageWrapper">
        		<img id="base-image" src="./assets/img/background.png" />
        		<div id="slots"/>
	            <div id="inventoryBox" >
	            	<h3>Inventory</h3>
	            	<hr>
	            	<div class="tab">
						<button class="tabButton" onclick="openInventoryTab(event, 'chestTab')">Chests</button>
						<button class="tabButton" onclick="openInventoryTab(event, 'helmetTab')">Helmets</button>
						<button class="tabButton" onclick="openInventoryTab(event, 'gloveTab')">Gloves</button>
						<button class="tabButton" onclick="openInventoryTab(event, 'bootTab')">Boots</button>
						<button class="tabButton" onclick="openInventoryTab(event, 'ringTab')">Rings</button>
						<button class="tabButton" onclick="openInventoryTab(event, 'amuletTab')">Amulets</button>
						<button class="tabButton" onclick="openInventoryTab(event, 'beltTab')">Belts</button>
						<button class="tabButton" onclick="openInventoryTab(event, 'weaponTab')">Weapons</button>
					</div>
					<!-- Tab content -->
					<div id="chestTab" class="tabContent"></div>
					<div id="helmetTab" class="tabContent"></div>
					<div id="gloveTab" class="tabContent"></div>
					<div id="bootTab" class="tabContent"></div>
					<div id="ringTab" class="tabContent"></div>
					<div id="amuletTab" class="tabContent"></div>
					<div id="beltTab" class="tabContent"></div>
					<div id="weaponTab" class="tabContent"></div>
		    	</div>
        	</div>
    
            <p> This is a customized <strong>Path of Exile</strong> custom equipment build.</p>
            <p> The project consists of weapons and armors for the user to choose and build.</p>
            <p> We are dedicated provide the best gaming experience for you!</p>
		</div>
</div>