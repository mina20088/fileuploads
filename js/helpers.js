//getting the extension of the file from file name
function getExtension(filename)
{
    return filename.slice(filename.indexOf('.')+1);
}

//matching the file against regular expression for validation
function ValidateFileName(filename)
{
    let regExp = /^\w+\.[a-z]+$/g
    return !!filename.match(regExp);

}
