<?php /* #?ini charset="utf-8"?

################################
########## Vues full ##########
################################

[home]
Source=node/view/full.tpl
MatchFile=node/view/full/home.tpl
Subdir=templates
Match[node]=2

[full_form]
Source=node/view/full.tpl
MatchFile=node/view/full/form.tpl
Subdir=templates
Match[class_identifier]=contact

[full_ong]
Source=node/view/full.tpl
MatchFile=node/view/full/asbl.tpl
Subdir=templates
Match[class_identifier]=ong

################################
########## Vues line ##########
################################

[line_ong]
Source=node/view/line.tpl
MatchFile=node/view/line/asbl.tpl
Subdir=templates
Match[class_identifier]=ong

################################
########## Vues embed ##########
################################

[embed_link]
Source=node/view/embed.tpl
MatchFile=node/view/embed/link.tpl
Subdir=templates
Match[class_identifier]=link

################################
########## Vues datatype #######
################################

[datatype_telephone1]
Source=content/datatype/view/ezstring.tpl
MatchFile=content/datatype/view/ezstring/telephone.tpl
Subdir=templates
Match[attribute_identifier]=telephone1

[datatype_telephone2]
Source=content/datatype/view/ezstring.tpl
MatchFile=content/datatype/view/ezstring/telephone.tpl
Subdir=templates
Match[attribute_identifier]=telephone2

[datatype_telephone3]
Source=content/datatype/view/ezstring.tpl
MatchFile=content/datatype/view/ezstring/telephone.tpl
Subdir=templates
Match[attribute_identifier]=telephone3

################################
########## Vues visuel #########
################################

*/ ?>