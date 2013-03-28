<?php
  cclass CTheSQL extends CActiveRecordBehavior
  {
    public function getSql($dataProvider=null, $tableAlias='t')
    {
      if(empty($dataProvider)) $dataProvider = $this->Owner->search();
      $dataProvider->criteria->mergeWith($this->Owner->defaultScope());
      $schema = Yii::app()->db->schema;
      $cbuilder = new CDbCommandBuilder($schema);
      $sqlCommand = $cbuilder->createFindCommand($this->Owner->tableName(), $dataProvider->criteria,$tableAlias);
      $sql = $sqlCommand->text;

    //we need to reverse sort the params array so the str_replace will work correctly for keys with same prefix + higher index
	  //eg:  :ycp0 .....:ycp01 
	  $params = $dataProvider->criteria->params;
	  krsort($params);
	
      foreach($params as $key=>$value) {
        $sql = str_replace($key, "'" . addslashes($value) . "'", $sql);
	    }	
      return $sql;
    }
  }
