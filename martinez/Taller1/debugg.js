function createTable(idDiv) {
    let table, row, celd, k = 0;
    table = document.createElement("TABLE");
    for (let j = 0; j < 3; j++) {
        row = document.createElement("TR");
        for (let i = 0; i < 3; i++) {
            k += 1;
            celd = document.createElement("TD");
            const btn = document.createElement('input');
            btn.id = 'button' + k
            btn.type = "button";
            btn.value = k.toString();
            btn.onclick = function btn_click(){
                // let btn= event.target;
                if (btn.innerHTML===btn.value){
                    btn.innerHTML='O';
                }else{
                    btn.innerHTML='X';
                }
                btn.disabled=true
                alert("hola celda "+btn.value)
            };
            celd.appendChild(btn);
            row.appendChild(celd);
        }
        table.appendChild(row)
    }
    document.getElementById(idDiv).innerHTML = "";
    document.getElementById(idDiv).appendChild(table)
}