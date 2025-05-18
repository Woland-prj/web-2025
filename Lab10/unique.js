function uniqueElements(arr) {
    const result = {}
    if (!Array.isArray(arr)) return result
  
    for (let item of arr) {
        const key = String(item)
        result[key] = (result[key] || 0) + 1
    }
  
    return result
}
  
let arr = ['привет', 'hello', 1, '1', 'true', 'true', true]
console.log(uniqueElements(arr))
