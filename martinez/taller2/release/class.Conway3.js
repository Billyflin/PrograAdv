let activeObj;
class Conway {
    constructor(i, j) {
        activeObj=this;
        this.alto = i
        this.ancho = j
        this.celula = []
        this.creaCelulas()
    }

    proximoTurno() {
        let celula = []
        for (let i = 0; i < this.alto; i++) {
            celula[i] = []
            for (let j = 0; j < this.ancho; j++) {
                let v = this.vecinasVivas(i, j);
                if (this.estaMuerta() && v === 3) {
                    celula[i][j] = true
                } else celula[i][j] = !!(this.estaViva(i, j) && (v === 2 || v === 3));
            }
        }
        this.celula = celula
    }

    creaCelulas() {
        let i, j;
        for (i = 0; i < this.alto; i++) {
            this.celula[i] = [];
            for (j = 0; j < this.ancho; j++) {
                this.celula[i][j] = false;

            }
        }
    }

    activa(i, j) {
        if (this.posicionOK(i, j)) {
            this.celula[i][j] = true;
        }
    }
    noActiva(i, j) {
        if (this.posicionOK(i, j)) {
            this.celula[i][j] = false;
        }
    }

    estaViva(i, j) {
        if (this.posicionOK(i, j)) return this.celula[i][j]; else return false;
    }

    posicionOK(i, j) {
        return (i >= 0 && i < this.alto && j >= 0 && j < this.ancho);
    }


    inyectaAmbiente(idDiv) {
        let table, row, celd, i, j;
        table = document.createElement("TABLE");
        table.setAttribute("class", "ambiente")
        for (i = 0; i < this.alto; i++) {
            row = document.createElement("TR");
            for (j = 0; j < this.ancho; j++) {
                celd = document.createElement("TD");
                if (this.estaViva(i, j)) {
                    celd.setAttribute("class", "celula viva")
                } else {
                    celd.setAttribute("class", "celula muerta")
                }
                activeObj=this;
                celd.setAttribute("id", `celula(${i},${j})`);
                let st="activeObj.cambiaEstado("+i+","+j+")"
                celd.setAttribute("onclick",st)
                row.appendChild(celd)
            }
            table.appendChild(row)
        }
        document.getElementById(idDiv).appendChild(table)
    }
    cambiaEstado(i,j){
        let item=document.getElementById(`celula(${i},${j})`)
        if (!this.estaViva(i,j)){
            this.activa(i,j)
            item.setAttribute("class", "celula viva")
        }
        else{
            this.noActiva(i,j)
            item.setAttribute("class", "celula muerta")
        }
    }

    vecinasVivas(i, j) {
        let total = 0
        if (this.estaViva(i - 1, j - 1)) total++
        if (this.estaViva(i, j - 1)) total++
        if (this.estaViva(i + 1, j - 1)) total++
        if (this.estaViva(i - 1, j)) total++
        if (this.estaViva(i + 1, j)) total++
        if (this.estaViva(i - 1, j + 1)) total++
        if (this.estaViva(i, j + 1)) total++
        if (this.estaViva(i + 1, j + 1)) total++
        return total;
    }

    agregaPatron(fila, columna, nombrePatron) {
        let y = fila;
        let x = columna;
        if (nombrePatron === "pentaDecatlon") {
            console.log("llega");
            for (let i = x; i < (x + 8); i++) {
                for (let j = y; j < (y + 3); j++) {
                    console.log("activando " + i + "  ,  " + j);
                    this.activa(i, j);
                }
                this.celula[x + 1][y + 1] = false;
                this.celula[x + 6][y + 1] = false;
            }
        }
        if (nombrePatron === "Planeador") {
            console.log("llega");
            for (let i = x; i < (x+4); i++) {
                for (let j = y; j < (y+5); j++) {
                    if(((i-x)===0&&(j-y)===0)||((i-x)===0&&(j-y)===3)){
                        this.activa(i,j);
                    }if((i-x)===1&&(j-y)===4){
                        this.activa(i,j);
                    }if(((i-x)===2&&(j-y)===0)||((i-x)===2&&(j-y)===4)){
                        this.activa(i,j);
                    }if((i-x)===3&&((j-y)!==0)){
                        this.activa(i,j);
                    }
                }
            }
        }
        if (nombrePatron === "Acorn") {
            console.log("llega");
            for (let i = x; i < (x+3); i++) {
                for (let j = y; j < (y+7); j++) {
                    if((i-x)===0&&(j-y)===1){
                        this.activa(i,j);
                    }if((i-x)===1&&(j-y)===3) {
                        this.activa(i, j);
                    }if((i-x)===2&&((j-y)!==3)&&((j-y)!==2)){
                        this.activa(i,j);
                    }
                }
            }
        }
    }
    estaMuerta() {
        return !this.estaViva()
    }
}