let activeObjectArbolNavidad;
let ns = "http://www.w3.org/2000/svg";

class ArbolNavidad {

    constructor() {
        activeObjectArbolNavidad = this;
        this.svg = document.createElementNS(ns, "svg");

        this.luces = [];

        this.circuitos = [
            {ms: 400, ids: []},
            {ms: 600, ids: []},
            {ms: 1000, ids: []}
        ];

        this.activo = false;

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

        let rect1 = this.crearCuadrado(200, 600, 50, "gray");
        rect1.setAttribute("id", "switch");
        rect1.setAttribute("onclick", "activeObjectArbolNavidad.clicEnSwitch('switch')");

        let rect2 = this.crearCuadrado(250, 600, 50, this.colorActual);
        rect2.setAttribute("id", "selector-color");
        rect2.setAttribute("onclick", "activeObjectArbolNavidad.clicSelectorColor('selector-color')");

        this.svg.appendChild(arbol);
        this.svg.appendChild(rect1);
        this.svg.appendChild(rect2);
        div.appendChild(this.svg);
    }

    crearCuadrado(x, y, lado, color) {
        let cuadrado = document.createElementNS(ns, "rect");
        cuadrado.setAttribute("x", x);
        cuadrado.setAttribute("y", y);
        cuadrado.setAttribute("width", lado);
        cuadrado.setAttribute("height", lado);
        cuadrado.setAttribute("fill", color);

        return cuadrado;
    }

    clicEnArbol() {
        let posX = event.clientX;
        let posY = event.clientY;
        let circuitoActual = this.calcularCircuito();

        this.ponerLuz(posX, posY, circuitoActual, this.colorActual);

        this.luces.push({
            x: posX,
            y: posY,
            color: this.colorActual,
            circuito: circuitoActual
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

    clicEnSwitch(id) {
        let cuadrado = document.getElementById(id);

        if (cuadrado.getAttribute("fill") === "gray") {
            cuadrado.setAttribute("fill", "yellow");
            this.activo = true;
            this.iniciarParpadeo();
        }
        else {
            cuadrado.setAttribute("fill", "gray");
            this.activo = false;
            this.finalizarParpadeo();
        }
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

    iniciarParpadeo() {
        for (let i = 1; i <= this.circuitos.length; i++) {
            for (let idLuz of this.circuitos[i - 1].ids) {

                let luz = document.getElementById(idLuz);
                let milisecs = this.circuitos[i - 1].ms;

                luz.appendChild(this.crearParpadeo(idLuz, milisecs));
            }
        }
    }

    finalizarParpadeo() {
        // Elimina las animaciones de todas las luces
        for (let i = 1; i <= this.circuitos.length; i++) {
            for (let idLuz of this.circuitos[i - 1].ids) {
                let luz = document.getElementById(idLuz);
                luz.innerHTML = "";
            }
        }
    }

    clicSelectorColor(idSelector) {
        if (this.colorActual === "yellow")
            this.colorActual = "red"
        else if (this.colorActual === "red")
            this.colorActual = "blue"
        else
            this.colorActual = "yellow"

        document.getElementById(idSelector).setAttribute("fill", this.colorActual);
    }

    clicEnLuzActiva(idLuz) {

        if (this.activo) {
            let luz = document.getElementById(idLuz);

            let agrandar = this.crearCambioTamanio("10", "50", "click", "2000ms");
            agrandar.setAttribute("id", idLuz + "agrandar");

            agrandar.setAttribute("restart", "whenNotActive");

            let achicar = this.crearCambioTamanio("50", "10", idLuz + "agrandar.begin + 2000ms", "2000ms");
            achicar.setAttribute("id", idLuz + "achicar");

            achicar.setAttribute("restart", "whenNotActive");

            let parpadeo = document.getElementById(idLuz + "parpadeo");
            parpadeo.setAttribute("begin", idLuz + "achicar.begin + 2000ms");

            luz.innerHTML = "";
            luz.appendChild(agrandar);
            luz.appendChild(achicar);
            luz.appendChild(parpadeo);
        }
    }

    crearCambioTamanio(from, to, begin, milisecs) {
        let animacion = document.createElementNS(ns, "animate");

        animacion.setAttribute("attributeType", "XML");
        animacion.setAttribute("attributeName", "r");
        animacion.setAttribute("from", from);
        animacion.setAttribute("to", to);
        animacion.setAttribute("begin", begin);
        animacion.setAttribute("dur", milisecs);
        animacion.setAttribute("fill", "freeze");

        return animacion;
    }
}