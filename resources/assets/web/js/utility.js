export function shorter(string, max = 25){
    if(string.length > max){
        string = string.substr(0,max);
        string += '...';
    }
    return string;
}