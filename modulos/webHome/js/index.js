var imagenes=0;

$(document).ready(function()
{
    imagenes=$("div.galery img").length;


    $("div.galery ul").css({"width":imagenes*100 +"%"});
    $("div.galery ul li").css({"width":(100/imagenes) +"%"});
    
    
    siguiente(1);
    
});

function siguiente(index)
{
    $("div.galery ul li").css({"display":"none"});       
    $("div.galery ul li:nth-child("+ index +")").show();

    setTimeout(function() 
    {
        if(index<imagenes)
            index+=1;
        else    
            index=1;
            
        siguiente(index);
    }, 3000 );
}
