function isObject(obj) {
    return (
        typeof obj === 'object' &&
        obj !== null &&
        !Array.isArray(obj)
    )
}

function mergeObjects(obj1, obj2) {
    if (!isObject(obj1) || !isObject(obj2)) return {}

    const res = { ...obj1, ...obj2 }

    // for (let key in obj2) {
    //     res[key] = obj2[key]
    // }

    return res
}

console.log(mergeObjects({ a: 1, b: 2 }, { b: 3, c: 4 })) // { a: 1, b: 3, c: 4 }
