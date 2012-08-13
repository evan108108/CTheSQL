<?php
  class CTheSQL extends CActiveRecordBehavior
  {
    public function getSql($dataProvider=null, $tableAlias='t')
    {
      if(empty($dataProvider)) $dataProvider = $this->Owner->search();
      $schema = Yii::app()->db->schema;
      $cbuilder = new CDbCommandBuilder($schema);
      $sqlCommand = $cbuilder->createFindCommand($this->Owner->tableName(),$dataProvider->criteria,$tableAlias);
      $sql = $sqlCommand->text;
      foreach($dataProvider->criteria->params as $key=>$value)
        $sql = str_replace($key, "'" . addslashes($value) . "'", $sql);
      return $sql;
    }
  }
