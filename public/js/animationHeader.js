const currentLocation = location.href;
const menuItem = document.querySelectorAll('a');
const menuLength = menuItem.length;
for(let i = 0; i < menuLength; i++){
    if (menuItem[i].href === currentLocation) {
        if (menuItem[i].className == "dropdown-item") {
            menuItem[i].className = "dropdown-item active";
        }
        else if(menuItem[i].className == "nav-link"){
            menuItem[i].className = "nav-link active";
        }
    }
}
