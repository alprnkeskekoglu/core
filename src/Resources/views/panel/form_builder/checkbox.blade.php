{
"metas": [
{
"type": "title"
},
{
"type": "description"
}
],
"general": [
{
"name": "status",
"type": "checkbox",
"multiple": "1",
"input": {
"attributes": {
"class": "custom-control-input"
}
},
"label": {
"text": {
"en": "Status",
"tr": "Durum"
}
},
"options": [
{
"text": {
"en": "Active",
"tr": "Aktif"
},
"color": "success",
"value": 1
},
{
"text": {
"en": "Draft",
"tr": "Taslak"
},
"color": "light",
"value": 2
},
{
"text": {
"en": "Passive",
"tr": "Pasif"
},
"color": "danger",
"value": 3
}
],
"multiple": "1",
"parent_class": "col-md-6"
},
{
"name": "order",
"type": "input",
"input": {
"attributes": {
"type": "number",
"class": "form-control"
}
},
"label": {
"text": {
"en": "Order",
"tr": "Sıralama"
}
},
"parent_class": "col-md-6"
},
{
"name": "image",
"type": "media",
"label": {
"text": {
"en": "Page Image",
"tr": "Sayfa Görseli"
}
},
"media_type": "image",
"parent_class": "col-md-12 mt-3",
"max_media_count": 1
}
],
"languages": [
{
"name": "detail.status",
"type": "radio",
"input": {
"attributes": {
"class": "custom-control-input"
}
},
"label": {
"text": {
"en": "Status",
"tr": "Durum"
}
},
"options": [
{
"text": {
"en": "Active",
"tr": "Aktif"
},
"color": "success",
"value": 1
},
{
"text": {
"en": "Passive",
"tr": "Pasif"
},
"color": "danger",
"value": 3
}
],
"parent_class": "col-md-12"
},
{
"name": "detail.name",
"type": "input",
"input": {
"attributes": {
"class": "form-control"
}
},
"label": {
"text": {
"en": "Page Name",
"tr": "Sayfa Adı"
}
},
"parent_class": "col-md-6"
},
{
"name": "detail.slug",
"type": "input",
"input": {
"attributes": {
"class": "form-control"
}
},
"label": {
"text": {
"en": "Page Slug",
"tr": "Sayfa Slug"
}
},
"parent_class": "col-md-6"
},
{
"name": "detail.detail",
"type": "ckeditor",
"label": {
"text": {
"en": "Page Detail",
"tr": "Sayfa Detayı"
}
},
"parent_class": "col-md-12"
}
]
}
