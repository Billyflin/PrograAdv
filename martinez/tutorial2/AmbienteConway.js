class AmbienteConway {
    constructor(i, j) {
        this.alto = i
        this.ancho = j
        this.celula = []
        this.creaCelulas()
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
        if (this.posicionOK(i,j)) {
            this.celula[i][j] = true;
        }
    }

    estaViva(i, j) {
        if (this.posicionOK(i, j))
            return this.celula[i][j];
        else
            return false;
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
                if (this.estaViva(i,j)){
                    celd.setAttribute("class","celula viva")
                }else{
                    celd.setAttribute("class","celula muerta")
                }
                row.appendChild(celd)
            }
            table.appendChild(row)
        }
        document.getElementById(idDiv).appendChild(table)
    }

}