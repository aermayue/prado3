<?php
/**
 * TPgsqlColumnSchema class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2009 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

prado::using('System.Testing.Data.Schema.TDbColumnSchema');

/**
 * TPgsqlColumnSchema class describes the column meta data of a PostgreSQL table.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: TPgsqlColumnSchema.php 2679 2009-06-15 07:49:42Z Christophe.Boulain $
 * @package System.Testing.Data.Schema.pgsql
 * @since 1.0
 */
class TPgsqlColumnSchema extends TDbColumnSchema
{
	/**
	 * Extracts the PHP type from DB type.
	 * @param string DB type
	 */
	protected function extractType($dbType)
	{
		if(strpos($dbType,'integer')!==false || strpos($dbType,'oid')===0)
			$this->type='integer';
		else if(strpos($dbType,'bool')!==false)
			$this->type='boolean';
		else if(preg_match('/(real|float|double)/',$dbType))
			$this->type='double';
		else
			$this->type='string';
	}

	/**
	 * Extracts the default value for the column.
	 * The value is typecasted to correct PHP type.
	 * @param mixed the default value obtained from metadata
	 */
	protected function extractDefault($defaultValue)
	{
		if($defaultValue==='true')
			$this->defaultValue=true;
		else if($defaultValue==='false')
			$this->defaultValue=false;
		else if(strpos($defaultValue,'nextval')===0)
			$this->defaultValue=null;
		else if(preg_match('/\'(.*)\'::/',$defaultValue,$matches))
			$this->defaultValue=$this->typecast(str_replace("''","'",$matches[1]));
		else if(preg_match('/^-?\d+(\.\d*)?$/',$defaultValue,$matches))
			$this->defaultValue=$this->typecast($defaultValue);
		// else is null
	}
}