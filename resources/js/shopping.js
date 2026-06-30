// Construye una URL de Google Shopping para buscar un producto en tiendas online.
export function shoppingUrl(nombre) {
    const q = /liborio/i.test(nombre) ? nombre : `${nombre} Liborio`;
    return `https://www.google.com/search?tbm=shop&q=${encodeURIComponent(q)}`;
}
