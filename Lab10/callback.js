function isObject(obj) {
    return (
        typeof obj === 'object' &&
        obj !== null &&
        !Array.isArray(obj)
    )
}

function mapObject(obj, callback) {
    const result = {}
    if (!isObject(obj) || (typeof callback != 'function')) return result

    Object.keys(obj).forEach(key => {
        result[key] = callback(obj[key])
    })

    return result
}

const nums = { a: 1, b: 2, c: 3 }
console.log(mapObject(nums, x => x * 2))
  