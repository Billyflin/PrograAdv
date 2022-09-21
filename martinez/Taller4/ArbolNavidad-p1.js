let activeObjectArbolNavidad;
let ns = "http://www.w3.org/2000/svg";

class ArbolNavidad {

    constructor() {
        activeObjectArbolNavidad = this;
        this.svg = document.createElementNS(ns, "svg");

        this.luces = [];

        this.colorActual = "yellow";
    }

    muestra(idDiv) {
        let div = document.getElementById(idDiv);
        this.svg.setAttribute("width", 500);
        this.svg.setAttribute("height", 650);

        let arbol = document.createElementNS(ns, "polygon");
        let puntos = "250,60 100,400 120,400 80,500 100,500 60,600 440,600 400,500 420,500 380,400 400,400";
        arbol.setAttribute("points", puntos);
        arbol.setAttribute("fill", "#409040");
        arbol.setAttribute("onclick", "activeObjectArbolNavidad.clicEnArbol()")

        this.svg.appendChild(arbol);
        div.appendChild(this.svg);
    }


    clicEnArbol() {
        let posX = event.clientX;
        let posY = event.clientY;
        let circuitoActual = this.calcularCircuito();

        this.ponerLuz(posX, posY, circuitoActual, this.colorActual);

        this.luces.push({
            x: posX, y: posY, color: this.colorActual, circuito: circuitoActual
        });
        console.log(this.luces);
    }

    calcularCircuito() {
        return (this.luces.length % this.circuitos.length) + 1;
    }

    ponerLuz(x, y, circuito, color) {
        let luz = document.createElementNS(ns, "circle");
        luz.setAttribute("r", "10");
        luz.setAttribute("fill", color);
        luz.setAttribute("cx", x);
        luz.setAttribute("cy", y);

        let id = "luz" + this.luces.length;
        luz.setAttribute("id", id);
        luz.setAttribute("onclick", "activeObjectArbolNavidad.clicEnLuzActiva('" + id + "')");

        this.circuitos[circuito - 1].ids.push(id);

        if (this.activo) {
            let milisecs = this.circuitos[circuito - 1].ms;
            luz.appendChild(this.crearParpadeo(id, milisecs));
        }

        this.svg.appendChild(luz);
    }


    crearParpadeo(idLuz, milisecs) {
        let animacion = document.createElementNS(ns, "animate");

        animacion.setAttribute("attributeType", "XML");
        animacion.setAttribute("attributeName", "visibility");
        animacion.setAttribute("values", "hidden;visible");
        animacion.setAttribute("dur", "" + milisecs + "ms");
        animacion.setAttribute("repeatCount", "indefinite");
        animacion.setAttribute("id", idLuz + "parpadeo")

        return animacion;
    }


}
