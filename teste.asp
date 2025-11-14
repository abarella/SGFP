<%


'Response.Write("teste asp<br>colocar os reports aqui<br>")

'Response.Write(Request.QueryString) 
'Response.Write("<br>") 

'lote = Request("lote")
'pst_numero = Request("pst_numero")
'produto = Request("produto")
'ano = Request("ano")

'response.write(pst_numero) + "<br>"
'response.write(lote) + "<br>"
'response.write(produto) + "<br>"
'response.write(ano) + "<br>"


Dim reportname
reportname = "Report\cr_inscricao_2009.rpt"
%>
<!-- #include file="include/AlwaysRequiredSteps.asp" -->
<!-- #include file="include/MoreRequiredSteps.asp" -->

<%
For op = 1 to session("oRpt").Database.Tables.count
  with session("oRpt").Database.Tables(op).ConnectionProperties 
   .Item("Provider") = "SQLOLEDB"
   .Item("Data source") = "colibri\gds_2"
   .Item("user ID") = "crsa"
   .Item("Password") = "cr9537"
  End With
Next

Dim inicio, termino

inicio  = "1" 'request("inicio")
termino = "50" 'request("termino")

session("oRpt").ParameterFields.GetItemByName("@inicio").addcurrentvalue (CInt(inicio))
session("oRpt").ParameterFields.GetItemByName("@termino").addcurrentvalue (CInt(termino))

%>
<!-- #include file="include/SmartViewerActiveX.asp" -->  
