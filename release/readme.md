Observações

Na pesquisa para qualquer modulo se o usuario pesquisar por codigo ao digitar apenas
o numero do codigo a ferramenta pode não localizar corretamente, para isso é necessario
o usuario digitar o zero antes do codigo que a busca e realizada corretamente.

A ultima mudança que voce fez foi de modificar todas as rotas de Ajax do sistema
precisa fazer os teste para validar se estão funcionando.

Modificar todo os ajax para suportar a Loading Gif




DELETE FROM `itens_pedido_bebida`;
DELETE FROM `item_pedido_variedade`;
DELETE FROM `item_pedido_adicional`;
DELETE FROM `item_pedido`;
DELETE FROM `pedidos`;



ALTER TABLE itens_pedido_bebida AUTO_INCREMENT=0;
ALTER TABLE item_pedido_variedade AUTO_INCREMENT=0;
ALTER TABLE item_pedido_adicional AUTO_INCREMENT=0;
ALTER TABLE item_pedido AUTO_INCREMENT=0;
ALTER TABLE pedidos AUTO_INCREMENT=0;



DELETE FROM `comentarios`;