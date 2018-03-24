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

/* The old presets function, now removed. */
function replaceImage(e) {
    
}

/* Load/Unloads the homepage inventory. */
function openInventoryTab(event, tabName) {
    // Declare all variables
    var tabContent, tabButton;

    // Get all elements with class="tabContent" and hide them
    tabContent = document.getElementsByClassName("tabContent");
    for (var i = 0; i < tabContent.length; i++) {
        tabContent[i].style.display = "none";
    }

    tabButton = document.getElementsByClassName("tabButton");
    for (var i = 0; i < tabButton.length; i++) {
        tabButton[i].className = tabButton[i].className.replace(" active", "");
    }

    document.getElementById(tabName).style.display = "block";
    event.currentTarget.className += " active";
}

$().ready(function() {
	$.ajax({
		url: "/category/all",
		dataType: 'json',
		error: function( data ) {
			console.log( 'ERROR: ', data );
		},
		success: function( data ) {
			console.log( 'SUCCESS: ' );
			$.each( data, function( key, val ) {
				var item = document.createElement("img");
				item.setAttribute("id", val.id);
				item.setAttribute("src", "./assets/img/" + val.id + ".png");
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
});

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
		top: 10px;
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
	    /*transition: 0.3s;*/
	}

	.tabContent {
	    display: none;
	}

	#statsBox {
		position: absolute;
		top: 220px;
		left: 780px;
		max-width: 25%; 
		/*max-width: 30%; */

		border-style: double;
		border-radius: 5px;
		border-width: 5px;
		border-color: black;
		text-align: center;
	}
</style>
<div class="POE_main">
	
		<h1 id="homepage-title">Welcome to Path of Exile custom mod!</h1>
		<div class="homepage-content">
            <div id="preset-dropdown">
            <select class="round" name="preset-dropdown" onchange="replaceImage(this);">
                {parts}
                  <option value={name}>{name}</option>
                {/parts}
            </select>
            </div>
			<div id="statsBox">
				<div class="container">
					<div class="row">					
					<h3 class="col-sm-1">Stats</h3 >
					</div>
					<div class="row">					
					<p class="col-sm-1">Strength</p>
					<p class="col-sm-1">Dexterity</p>
					<p class="col-sm-1">Intelligence</p>
					</div>
					<div class="row">					
					<p id="strField" class="col-sm-1">0</p>
					<p id="dexField" class="col-sm-1">0</p>
					<p id="intField" class="col-sm-1">0</p>
					</div>
				</div>
			</div>	
            <div class="imageWrapper">
            	
        		<img id="base-image" src="./assets/img/background.png" />
				<div class="chest" data-category="chest" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="chest" src="./assets/img/chest_slot.png" data-str="0" data-dex="0" data-int="0">
				</div>	
				<div class="helmet" data-category="helmet" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="helmet" src="./assets/img/helmet_slot.png" data-str="0" data-dex="0" data-int="0">
				</div>	
				<div class="glove" data-category="glove" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="glove" src="./assets/img/helmet_slot.png" data-str="0" data-dex="0" data-int="0">
				</div>	
				<div class="boot" data-category="boot" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="boot" src="./assets/img/helmet_slot.png" data-str="0" data-dex="0" data-int="0">
				</div>	
				<div class="ring_left" data-category="ring" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="ring_left" src="./assets/img/ring_slot.png" data-str="0" data-dex="0" data-int="0">
				</div>	
				<div class="ring_right" data-category="ring" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="ring_right" src="./assets/img/ring_slot.png" data-str="0" data-dex="0" data-int="0">
				</div>	
				<div class="amulet" data-category="amulet" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="amulet" src="./assets/img/ring_slot.png" data-str="0" data-dex="0" data-int="0">
				</div>	
				<div class="belt" data-category="belt" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="belt" src="./assets/img/belt_slot.png" data-str="0" data-dex="0" data-int="0">
				</div>	
				<div class="weapon_left" data-category="weapon" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="weapon_left" src="./assets/img/weapon_slot.png" data-str="0" data-dex="0" data-int="0">
				</div>	
				<div class="weapon_right" data-category="weapon" ondrop="drop(this, event)" ondragenter="return false" ondragover="return false" >
					<img id="weapon_right" src="./assets/img/weapon_slot.png" data-str="0" data-dex="0" data-int="0">
				</div>	
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
