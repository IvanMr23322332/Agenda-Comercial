function accordion(id){
    var appBanners = document.getElementsByClassName('collapse-lvl2');

    if( document.getElementById(id).style.display == 'block' ){
        document.getElementById(id).style.display= 'none';
        return;
    }

    for (var i = 0; i < appBanners.length; i ++) {
      appBanners[i].style.display = 'none';
    }
      document.getElementById(id).style.display= 'block';
}
