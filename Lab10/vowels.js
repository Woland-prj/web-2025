function countVowels(str) {
    const vowels = "аеёиоуыэюяАЕЁИОУЫЭЮЯ"
    let count = 0
    
    for (let char of str) {
        if (vowels.includes(char)) {
            count++
        }
    }
    
    return count
}

let str = "Привет, мир!"
console.log(countVowels(str))